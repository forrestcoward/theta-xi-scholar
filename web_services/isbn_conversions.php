<?php

// Contains functions to convert between isbn 10 and isbn 13. 

// Converts ISBN-10 to ISBN-13
// Leaves ISBN-13 numbers (or anything else not matching 10 consecutive numbers) alone.
function ISBN10toISBN13($isbn) {
    if (!preg_match('{^([0-9]{9})[0-9xX]$}', $isbn, $matches)) {
        return $isbn;
    }

    # sum the digits with their weights and add the checksum for the 978 prefix
    $sum_of_digits = 38 + 3 * ($isbn{0} + $isbn{2} + $isbn{4} + $isbn{6} + $isbn{8}) +
                               $isbn{1} + $isbn{3} + $isbn{5} + $isbn{7};

    # divide the sum_of_digits by the modulus number (10) to find the remainder
    # and then minus 10 to get the check digit
    $check_digit = (10 - ($sum_of_digits % 10)) % 10;

    # return isbn with check_digit
    return '978' . $matches[1] . $check_digit;
}

// Converts ISBN-13 to ISBN-10
// Leaves ISBN-10 numbers (or anything else not matching 13 consecutive numbers) alone.
function ISBN13toISBN10($isbn) {
	if (preg_match('/^\d{3}(\d{9})\d$/', $isbn, $m)) {
		$sequence = $m[1];
		$sum = 0;
		$mul = 10;
		for ($i = 0; $i < 9; $i++) {
			$sum = $sum + ($mul * (int) $sequence{$i});
			$mul--;
		}
		$mod = 11 - ($sum%11);
		if ($mod == 10) {
			$mod = "X";
		}
		else if ($mod == 11) {
			$mod = 0;
		}
		$isbn = $sequence.$mod;
	}
	return $isbn;
}  

// Check if an ISBN number is valid. Works on both 10 and 13 digit ISBN numbers.
function checkIsbn($isbn) {

	if(strlen($isbn) != 10 && strlen($isbn) != 13) {
		return false;
	}
	return true;

	if(strlen($isbn) == 10) {
		if(preg_match('{^([0-9]{9})[0-9xX]$}', $isbn, $matches)) {
			return check_10_digit($isbn);
		} else {
			return false;
		}
	}
	if(strlen($isbn) == 13) {
		if (preg_match('/^\d{3}(\d{9})\d$/', $isbn, $m)) {
			return check_13_digit($isbn);
		} else {
			return false;
		}
	}
	return false;
}


function check_10_digit($x) {
    $check = 0;
    for ($i = 0; $i < 9; $i++) $check += (10 - $i) * substr($n, $i, 1);
    $t = substr($n, 9, 1); // tenth digit (aka checksum or check digit)
    $check += ($t == 'x' || $t == 'X') ? 10 : $t;
    return $check % 11 == 0;
}

function check_13_digit($x) {
    $check = 0;
    for ($i = 0; $i < 13; $i+=2) $check += substr($n, $i, 1);
    for ($i = 1; $i < 12; $i+=2) $check += 3 * substr($n, $i, 1);
    return $check % 10 == 0;
}

?>