<?php
namespace App\Classes;

use App\Models\ProjectOperator;
use Illuminate\Support\Facades\Gate;

class ClientMenu extends Menu
{

    public function __construct()
    {
        parent::__construct();

        $list = [
            $this->ordersMenu(),
            $this->profileMenu(),
            $this->favouritesMenu(),
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
