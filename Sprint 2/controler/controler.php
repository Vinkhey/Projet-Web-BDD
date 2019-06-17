<?php
/**
 * Created by PhpStorm.
 * User: Pascal.BENZONANA
 * Date: 08.05.2017
 * Time: 09:10
 * Updated by : 12-MAR-2019 - nicolas.glassey
 *              Add register function
 */

/**
 * This function is designed to redirect the user to the home page (depending on the action received by the index)
 */

function home(){
    $_GET['action'] = "home";
    require "view/home.php";
}

//region users management
/**
 * This function is designed to manage login request
 * @param $loginRequest containing login fields required to authenticate the user
 */
function login($loginRequest){
    //if a login request was submitted
    if (isset($loginRequest['inputUserEmailAddress']) && isset($loginRequest['inputUserPsw'])) {
        //extract login parameters
        $userEmailAddress = $loginRequest['inputUserEmailAddress'];
        $userPsw = $loginRequest['inputUserPsw'];

        //try to check if user/psw are matching with the database
        require_once "model/usersManager.php";
        if (isLoginCorrect($userEmailAddress, $userPsw)) {
            createSession($userEmailAddress);
            $_GET['loginError'] = false;
            $_GET['action'] = "home";
            require "view/home.php";
        } else { //if the user/psw does not match, login form appears again
            $_GET['loginError'] = true;
            $_GET['action'] = "login";
            require "view/login.php";
        }
    }else{ //the user does not yet fill the form
        $_GET['action'] = "login";
        require "view/login.php";
    }
}

/**
 * This fonction is designed
 * @param $registerRequest
 */
function register($registerRequest){
    //variable set
    if (isset($registerRequest['inputUserEmailAddress']) && isset($registerRequest['inputUserPsw']) && isset($registerRequest['inputUserPswRepeat'])) {

        //extract register parameters
        $userEmailAddress = $registerRequest['inputUserEmailAddress'];
        $userPsw = $registerRequest['inputUserPsw'];
        $userPswRepeat = $registerRequest['inputUserPswRepeat'];

        if ($userPsw == $userPswRepeat){
            require_once "model/usersManager.php";
            if (registerNewAccount($userEmailAddress, $userPsw)){
                createSession($userEmailAddress);
                $_GET['registerError'] = false;
                $_GET['action'] = "home";
                require "view/home.php";
            }
            else
            {
                $_GET['registerError'] = true;
                $_GET['action'] = "register";
                require "view/register.php";
            }
        }else{
            $_GET['registerError'] = true;
            $_GET['action'] = "register";
            require "view/register.php";
        }
    }else{
        $_GET['action'] = "register";
        require "view/register.php";
    }
}

/**
 * This function is designed to create a new user session
 * @param $userEmailAddress : user unique id
 */
function createSession($userEmailAddress){
    $_SESSION['userEmailAddress'] = $userEmailAddress;
    //set user type in Session
    $userType = getUserType($userEmailAddress);
    $userId = getUserId($userEmailAddress);
    $_SESSION['userType'] = $userType;
    $_SESSION['userId'] = $userId;
}

/**
 * This function is designed to manage logout request
 */
function logout(){
    $_SESSION = array();
    session_destroy();
    $_GET['action'] = "home";
    require "view/home.php";
}
//endregion


//region snows management
/**
 * This function is designed to display Snows
 * There are two different view available.
 * One for the seller, an other one for the customer.
 */
function displaySnows(){
    if (isset($_POST['resetCart'])) {
        unset($_SESSION['cart']);
    }

    require_once "model/snowsManager.php";
    $snowsResults = getSnows();

    $_GET['action'] = "displaySnows";
    if (isset($_SESSION['userType']))
    {
        switch ($_SESSION['userType']) {
            case 1://this is a customer
                require "view/snows.php";
                break;
            case 2://this a seller
                require "view/snowsSeller.php";
                break;
            default:
                require "view/snows.php";
                break;
        }
    }else{
        require "view/snows.php";
    }
}

/**
 * This function is designed to get only one snow results (for aSnow view)
 * @param none
 */
function displayASnow($snow_code){
    if (isset($registerRequest['inputUserEmailAddress'])){
        //TODO
    }
    require_once "model/snowsManager.php";
    $snowsResults= getASnow($snow_code);
    require "view/aSnow.php";
}
//endregion

//region Cart Management
function displayCart(){
    $_GET['action'] = "cart";
    require "view/cart.php";
}

function snowLeasingRequest($snowCode){
    if (isset($_SESSION['userEmailAddress'])) {
        require "model/snowsManager.php";
        $snowsResults = getASnow($snowCode);
        $_SESSION['snowId'] = $snowsResults['0']['idSnows'];
        $_GET['action'] = "snowLeasingRequest";
        require "view/snowLeasingRequest.php";
    }
    else{
            require "view/login.php";
        }
}

/**
 * This function designed to manage all request impacting the cart content
 * @param $snowCode
 * @param $snowLocationRequest
 */
function updateCartRequest($snowCode, $snowLocationRequest){
    $cartArrayTemp = array();
    if(($snowLocationRequest) AND ($snowCode)) {
        if (isset($_SESSION['cart'])) {
            $cartArrayTemp = $_SESSION['cart'];
        }

        require_once "model/LocationsManager.php";
        $result = getSnowsStock($_SESSION['snowId']);

        if($result != false)
        {
            $quantity = $result[0]['qtyAvailable'] - $snowLocationRequest['inputQuantity'];
            if($quantity < 0)
            {
                $_SESSION['CartErrors'] = true;
                snowLeasingRequest($_GET['code']);
            }
            else
            {
                if(isset($_SESSION['cart']))
                {
                    $testQuantityCart = $_SESSION['cart'][0]['qty'];
                }
                else
                {
                    $testQuantityCart = 1;
                }

                if($testQuantityCart > $quantity)
                {
                    $_SESSION['CartErrors'] = true;
                    snowLeasingRequest($_GET['code']);
                }
                else
                {
                    require "model/cartManager.php";
                    $cartArrayTemp = updateCart($_SESSION['snowId'],$cartArrayTemp, $snowCode, $snowLocationRequest['inputQuantity'], $snowLocationRequest['inputDays']);
                    $_SESSION['cart'] = $cartArrayTemp;

                    if(!isset($_SESSION['CartErrors']))
                    {
                        $test = 0;
                        foreach($_SESSION['cart'] as $key => $value)
                        {
                            if($value['code'] == $snowCode and isset($_SESSION['updateCartResult']) and $_SESSION['updateCartResult'] == true)
                            {
                                $test++;
                                if($test > 1)
                                {
                                    unset($_SESSION['cart'][$key]);
                                }
                            }
                        }
                    }
                    else
                    {
                        snowLeasingRequest($_GET['code']);
                    }
                }
            }
        }
        else
        {
            snowLeasingRequest($_GET['code']);
        }
    }

    $_GET['action'] = "displayCart";
    displayCart();
}

function endLocation(){
    $_GET['action'] = "endLocation";
    require "model/LocationsManager.php";
        if(isset($_SESSION['cart']))
        {
            $result = updateLocations($_SESSION['cart'], $_SESSION['userId']);
            if($result != false)
            {
                $_SESSION['location'] = getLocations($_SESSION['userId']);
                unset($_SESSION['cart']);
            }
            else
            {
                $_SESSION['LocationErrors'] = true;
                $_GET['action'] = "cart";
                require "view/cart.php";
            }

            require "view/endLocation.php";

        }
        else
        {
            $_SESSION['location'] = getLocations($_SESSION['userId']);
            require "view/endLocation.php";
        }
}

function managementReturn(){
    $_GET['action'] = "managementReturn";
    require "model/dbConnector.php";
    require "view/managementReturn.php";
}

function managementLocation()
{
    $_GET['action'] = "managementLocation";
    require "model/dbConnector.php";
    require "view/managementLocation.php";
}
//endregion