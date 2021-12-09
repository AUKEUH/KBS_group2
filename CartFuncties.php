<?php

function getCart(){
    if(isset($_SESSION['cart'])){               //controleren of winkelmandje (=cart) al bestaat
        $cart = $_SESSION['cart'];                  //zo ja:  ophalen
    } else{
        $cart = array();                            //zo nee: dan een nieuwe (nog lege) array
    }
    return $cart;                               // resulterend winkelmandje terug naar aanroeper functie
}

function saveCart($cart){
    $_SESSION["cart"] = $cart;                  // werk de "gedeelde" $_SESSION["cart"] bij met de meegestuurde gegevens
}

function addProductToCart($stockItemID){
    $cart = getCart();                          // eerst de huidige cart ophalen

    if(array_key_exists($stockItemID, $cart)){  //controleren of $stockItemID(=key!) al in array staat
        $cart[$stockItemID] += 1;                   //zo ja:  aantal met 1 verhogen
    }else{
        $cart[$stockItemID] = 1;                    //zo nee: key toevoegen en aantal op 1 zetten.
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}

function removeProductToCart($stockItemID){
    $cart = getCart();                          // eerst de huidige cart ophalen

    if(array_key_exists($stockItemID, $cart)){  //controleren of $stockItemID(=key!) al in array staat
        unset($cart[$stockItemID]);
    }


    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}


function plusProductToCart($stockItemID){
    $cart = getCart();                          // eerst de huidige cart ophalen

    if(array_key_exists($stockItemID, $cart)){  //controleren of $stockItemID(=key!) al in array staat
        $cart[$stockItemID] += 1;
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}


function minProductToCart($stockItemID){
    $cart = getCart();                          // eerst de huidige cart ophalen

    if(array_key_exists($stockItemID, $cart)){  //controleren of $stockItemID(=key!) al in array staat
      if ($cart[$stockItemID] > 0) {      //Kan je niet minder dan 0 aantal hebben
        $cart[$stockItemID] -= 1;
      }
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}

function saveOrder($databaseConnection){
    $cart = getCart();
    placeOrder($cart, $databaseConnection);
    updateStock($cart, $databaseConnection);
    header("Refresh:0; url=cart.php?order-success=1");
}
