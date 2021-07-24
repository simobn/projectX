<?php
/**
 * Class UserModel
 * @package app\Core
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */

namespace app\Core;
abstract class UserModel extends DbModel
{
    abstract public function getDisplayName() : string;
}