<?php

use Dto\ServiceContainer;
use Dto\Validators\Types\CustomDtoArrayValidator;


/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 6/26/18
 * Time: 5:51 PM
 */

class CustomDtoServiceContainer extends ServiceContainer {


    protected function init() {
        parent::init();

        $this->container['arrayValidator'] = function () {
            return new CustomDtoarrayValidator($this);
        };

    }
}