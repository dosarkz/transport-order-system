<?php
namespace App\Models;
use App\Classes\Field;
use Collective\Html\FormFacade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class TransportCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'position','image_id','type_id','status_id','_image_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;


    public function transportServices()
    {
        return $this->hasMany(TransportService::class, 'service_id');
    }

    public function transports()
    {
        return $this->hasMany(Transport::class, 'car_category_id');
    }

    public function countTransportServicesByCity()
    {
        if(request()->has('city_id')) {
            $city_id = request()->input('city_id');
            return  Transport::where('car_category_id', $this->id)->where('city_id', $city_id)->count();
        }

        $city = auth()->user()->city_id ? auth()->user()->city_id : 10;

        return  Transport::where('car_category_id', $this->id)->where('city_id', $city)->count();
    }


    private function commonCarSeats($transport)
    {
        return FormFacade::number('car_seats', $transport->car_seats, ['class' => 'form-control', 'placeholder' => 1]);
    }

    private function commonCarColor($transport)
    {
        return FormFacade::select('car_color',Color::pluck('name', 'id'), $transport->car_color, ['id' => 'car_color',
            'style' => 'width: 150px;', 'placeholder' => 'Выберите цвет']);
    }

    public function commonCarClass($transport)
    {
        return FormFacade::select('car_class_type_id',TransportClass::where('type_id', 3)->pluck('name', 'id'),
            $transport->car_class_type_id,
            ['id' => 'car_class_id', 'style' => 'width: 150px;', 'placeholder' => 'Выберите класс']);
    }

    public function listCommonFields($transport)
    {
        return [
            //Автобус
            16 => [
                new Field('Количество мест', $this->commonCarSeats($transport)),
                new Field('Цвет авто', $this->commonCarColor($transport)),
            ],
            //Легковые
            4 => [
                new Field('Количество мест', $this->commonCarSeats($transport)),
                new Field('Цвет авто', $this->commonCarColor($transport)),
                new Field('Класс авто', $this->commonCarClass($transport)),
            ],
//            5 => [
//                'fields' =>[
//                    new Field('Количество мест', $this->commonCarSeats($transport)),
//                    'car_cubage',
//                    'car_ton',
//                    'car_color'
//                ],
//                'name' => 'Грузовые'
//            ],
//            12 => [
//                'fields' => [
//                    'car_ton',
//                    'car_color',
//                    'car_special_tech_types'
//                ],
//                'name' => 'Кран'
//            ],
//            13 => [
//                'fields' => [
//                    'drawbar_category',
//                    'car_special_tech_types',
//                    'car_color',
//                ],
//                'name' => 'бульдозер'
//            ],
//
//            14 => [
//                'fields' => [
//                    'car_cubage',
//                    'car_special_tech_types',
//                    'drawbar_category',
//                    'car_color',
//                ],
//                'name' => 'Экскаватор'
//            ],
        ];
    }

    /**
     * @param $transport
     * @return array|mixed
     */
    public function getCommonFields($transport)
    {
        if(!array_key_exists($this->id, $this->listCommonFields($transport)))
        {
            return array();
        }

        return $this->listCommonFields($transport)[$this->id];
    }

}