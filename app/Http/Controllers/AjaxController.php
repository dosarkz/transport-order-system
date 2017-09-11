<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transport;
use App\Models\TransportBrand;
use App\Models\TransportDocument;
use App\Models\TransportImage;
use App\Models\TransportModel;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function newOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_start' => 'required',
            'start_point_text' => 'required',
            'end_point_text' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 422); // 400 being the HTTP code for an invalid request.
        }

        $request->merge([
            'date_start' => date('Y-m-d H:i:s',strtotime($request->input('date_start'))),
            'user_id' => auth()->user()->id,
            'status_id' => 0
        ]);

        $order =  Order::create($request->all());

        return response()->json(array('success' => true, 'order' => $order), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listAutoModels(Request $request)
    {
        $transport_models =  TransportModel::where('brand_id', $request->input('transport_brand_id'))
            ->where('category_id', $request->input('category_id'))
            ->pluck('name','id');
        return response()->json($transport_models);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listAutoBrands(Request $request)
    {
        $transport_models =  TransportBrand::whereHas('transport_brand_categories', function($query) use($request){
            $query->where('category_id', $request->input('category_id'));
        })->orderBy('name', 'asc')->pluck('name','id');

        return response()->json($transport_models);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listDrivers(Request $request)
    {
        $drivers =  User::join('transports', function($join) use($request){
            $join->on('users.id', '=', 'transports.car_driver_id')
                ->where('car_category_id', $request->input('transport_category_id'))
                ->where('car_brand_id', $request->input('transport_brand_id'));
        })
            ->select('transports.id as transport_id')
            ->distinct('transports.id')
            ->get();

        $list = [];

        foreach ($drivers as $driver) {
            $transport =  Transport::find($driver->transport_id);

            $list[] = [
                'auto' => $transport->transportBrand->name .' | '.$transport->car_gos_number.'  - '.
                    $transport->driver->fullName,
                'transport_id' => $transport->id
            ];
        }

        return response()->json($list);
    }

    public function listAllDrivers(Request $request)
    {
        $drivers =  User::join('transports', function($join){
            $join->on('users.id', '=', 'transports.car_driver_id');
        })
            ->select('transports.id as transport_id')
            ->distinct('transports.id')
            ->pluck('transport_id')->toArray();

        $q = $request->input('q');

        $transport =  Transport::join('transport_brands', 'transports.car_brand_id', '=', 'transport_brands.id')
            ->join('users', 'transports.car_driver_id', '=', 'users.id')
            ->select('transports.id', DB::raw('CONCAT(transport_brands.name,\' | \', transports.car_gos_number,\' - \', users.first_name,\' \', users.last_name) as text'))
            ->whereIn('transports.id',$drivers);

        if($request->has('q'))
        {
            $transport =  $transport->where('users.first_name', 'like', "%$q%")
                ->orWhere('users.last_name', 'like', "%$q%")
                ->orWhere('transports.car_gos_number', 'like', "%$q%")
                ->orWhere('transport_brands.name', 'like', "%$q%");
        }

        if($request->has('brand_id'))
        {
            $transport =  $transport->where('transports.car_brand_id', $request->input('brand_id'))
                ->where('transports.car_category_id', $request->input('category_id'));
        }

        return response()->json($transport->paginate(30));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeRole(Request $request)
    {
        $user_role = UserRole::whereHas('role', function($query) use($request){
            $query->where('alias', $request->input('role'));
        })
            ->where('user_id', auth()->user()->id)
            ->first();

        if(!$user_role){
            return response()->json(['success' => false]);
        }

        auth()->user()->update([
            'user_role_id' => $user_role->id
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyDocument($id)
    {
        $transport_document = TransportDocument::findOrFail($id);
        $transport_document->delete();

        return response()->json(['status' => 'deleted'], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyTransportImage($id)
    {
        $transport_image = TransportImage::findOrFail($id);

        if($transport_image->image)
        {
            if(file_exists($transport_image->image->getThumb()))
            {
                unlink($transport_image->image->getThumb());
            }

            if(file_exists($transport_image->image->getFullImage()))
            {
                unlink($transport_image->image->getFullImage());
            }
        }

        $transport_image->delete();

        return response()->json(['status' => 'deleted'], 200);
    }
}
