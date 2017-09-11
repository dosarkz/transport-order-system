<?php
namespace App\Classes;

class Menu {

    public $url;

    public $title;

    public $icon;

    public $sub_menu = [];

    public $position;
    public $lists = [];

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return array
     */
    public function getSubMenu()
    {
        return $this->sub_menu;
    }

    /**
     * @param array $sub_menu
     */
    public function setSubMenu($sub_menu)
    {
        $this->sub_menu = $sub_menu;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return array
     */
    public function getLists()
    {
        return $this->lists;
    }

    /**
     * @param array $lists
     */
    public function setLists($lists)
    {
        $this->lists = $lists;
    }



    public function __construct($title = '', $url  = '', $icon  = '', $sub_menu  = [], $position  = 0)
    {
        $this->icon = $icon;
        $this->title = $title;
        $this->url = $url;
        $this->sub_menu = $sub_menu;
        $this->position = $position;

    }

    public function main()
    {
       return new self('Главная', '/','fa-home',[], 1);
    }


    public function ordersMenu()
    {
        return new Menu('Мои заказы', '/orders','fa-file-text-o',[], 1);
    }

    public function driverOrdersMenu()
    {
        return new Menu('Мои заказы', '/driver/orders','fa-file-text-o',[], 1);
    }

    public function profileMenu()
    {
        return new Menu('Мои Профиль', '/profile','fa-user',[], 1);
    }

    public function favouritesMenu()
    {
        return new Menu('Мои избранные', '/favourites','fa-file-text-o',[], 1);
    }

    public function projectsMenu($projectOperators)
    {
        return new Menu('Мои проекты', '/projects','fa-file-text-o', auth()->user()->projectsLists($projectOperators));
    }

    public function transportMenu()
    {
        return new Menu('Мои авто', '/driver/transports','fa-car',[], 1);
    }

    public function specialOffersMenu()
    {
        return new Menu('Спец. предложения', '/driver/special-offers','fa-file-text-o',[], 1);
    }

    public function usersMenu()
    {
        return new Menu('Пользователи', '/admin/users','fa-file-text-o',[
            new Menu('Список', '/admin/users', 'fa-list-ul',[], 1),
            new Menu('Добавить', '/admin/users/create', 'fa-plus',[], 1),
        ], 1);
    }


    public function render()
    {
        return view('navigation.menu', ['lists' => $this->lists]);
    }


}