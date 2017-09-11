<?php
namespace App\Classes;

use App\Models\ProjectOperator;
use Illuminate\Support\Facades\Gate;

class DriverMenu extends Menu
{

    public function __construct()
    {
        parent::__construct();

        $list = [
            $this->driverOrdersMenu(),
            $this->transportMenu(),
            $this->specialOffersMenu(),
            $this->profileMenu(),
        ];

        $projectOperators = ProjectOperator::where('user_id', auth()->user()->id)->get();

        if(Gate::allows('show-projects-menu', $projectOperators)) {
            $list[] = $this->projectsMenu($projectOperators);
        }
        
        if(auth()->user()->hasRole('admin'))
        {
            $list[] = $this->usersMenu();
        }


        $this->setLists($list);
    }




}
