<?php
namespace App\Classes;

class AdminMenu extends Menu
{

    public function __construct()
    {
        parent::__construct();

        $this->setLists([
            $this->profileMenu(),
            $this->userMenu()
        ]);
    }

    public function userMenu()
    {
        return new Menu('Пользователи', '/admin/users','fa-file-text-o',[
            new Menu('Список', '/admin/users', 'fa-list-ul',[], 1),
            new Menu('Добавить', '/admin/users/create', 'fa-plus',[], 1),
        ], 1);
    }


}
