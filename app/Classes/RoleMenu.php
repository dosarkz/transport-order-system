<?php
namespace App\Classes;

class RoleMenu {

    private $role;

    public function __construct($role)
    {
        $this->role = $role;
    }


    public function render()
    {
      if(!$this->role)
      {
          $menu = new ClientMenu();
      }else{

          switch ($this->role->role->alias) {
              case 'admin':
                  $menu = new AdminMenu();
                  break;
              case 'client':
                  $menu = new ClientMenu();
                  break;
              case 'driver':
                  $menu = new DriverMenu();
                  break;

              default:
                  $menu = new ClientMenu();
                  break;
          }
      }

        return $menu->render();
    }
}