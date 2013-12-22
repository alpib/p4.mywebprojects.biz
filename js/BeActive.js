
//Function that only allows numbers, backspace and periods to be typed
function numbersonly(e){
    var unicode=e.charCode? e.charCode : e.keyCode
    //if the key isn't the backspace key and period for decimal point(which we should allow)
    if ((unicode!=8) & (unicode !=46)) { 
    if (unicode<48||unicode>57) //if not a number
    return false //disable key press
    }
}

