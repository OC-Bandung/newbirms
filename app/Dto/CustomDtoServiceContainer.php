<?php

namespace App\Dto;

use Dto\ServiceContainer;


/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 6/26/18
 * Time: 5:51 PM
 * Custom service container to override arrayValidator with a CustomDtoArrayValidator
 * All the rest of the init method settings are imported from
 */

class CustomDtoServiceContainer extends ServiceContainer {


    protected function init() {
        //invoke supermethod
        parent::init();

        $this->container['arrayValidator'] = function () {
            return new CustomDtoArrayValidator($this);
        };

    }
}