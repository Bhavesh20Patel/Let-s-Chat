<?php

$message = "Hello World";
echo $message;

define("BCCOMP_LARGER", 1);
class RSA
{
    protected $message = "Hello World";
    function rsa_encrypt($message, $public_key, $modulus, $keylength)
    {
        $padded = RSA::add_PKCS1_padding($message, true, $keylength / 8);
        $number = RSA::binary_to_number($padded);
        $encrypted = RSA::pow_mod($number, $public_key, $modulus);
        $result = RSA::number_to_binary($encrypted, $keylength / 8);
        echo $result;
        return $result;
    }
    function rsa_decrypt($message, $private_key, $modulus, $keylength)
    {
        $number = RSA::binary_to_number($message);
        $decrypted = RSA::pow_mod($number, $private_key, $modulus);
        $result = RSA::number_to_binary($decrypted, $keylength / 8);
        return RSA::remove_PKCS1_padding($result, $keylength / 8);
    }
    function rsa_sign($message, $private_key, $modulus, $keylength)
    {
        $padded = RSA::add_PKCS1_padding($message, false, $keylength / 8);
        $number = RSA::binary_to_number($padded);
        $signed = RSA::pow_mod($number, $private_key, $modulus);
        $result = RSA::number_to_binary($signed, $keylength / 8);
        return $result;
    }
    function rsa_verify($message, $public_key, $modulus, $keylength)
    {
        return RSA::rsa_decrypt($message, $public_key, $modulus, $keylength);
    }
    function rsa_kyp_verify($message, $public_key, $modulus, $keylength)
    {
        $number = RSA::binary_to_number($message);
        $decrypted = RSA::pow_mod($number, $public_key, $modulus);
        $result = RSA::number_to_binary($decrypted, $keylength / 8);
        return RSA::remove_KYP_padding($result, $keylength / 8);
    }
    function pow_mod($p, $q, $r)
    {
        $factors = array();
        $div = $q;
        $power_of_two = 0;
        while (bccomp($div, "0") == BCCOMP_LARGER) {
            $rem = bcmod($div, 2);
            $div = bcdiv($div, 2);
            if ($rem) {
                array_push($factors, $power_of_two);
            }
            $power_of_two++;
        }
        $partial_results = array();
        $part_res = $p;
        $idx = 0;
        foreach ($factors as $factor) {
            while ($idx < $factor) {
                $part_res = bcpow($part_res, "2");
                $part_res = bcmod($part_res, $r);
                $idx++;
            }
            array_push($partial_results, $part_res);
        }
        $result = "1";
        foreach ($partial_results as $part_res) {
            $result = bcmul($result, $part_res);
            $result = bcmod($result, $r);
        }
        return $result;
    }
    function add_PKCS1_padding($data, $isPublicKey, $blocksize)
    {
        $pad_length = $blocksize - 3 - strlen($data);
        if ($isPublicKey) {
            $block_type = "";
            $padding = "";
            for ($i = 0; $i < $pad_length; $i++) {
                $rnd = mt_rand(1, 255);
                $padding .= chr($rnd);
            }
        } else {
            $block_type = "";
            $padding = str_repeat("ÿ", $pad_length);
        }
        return "" . $block_type . $padding . "" . $data;
    }
    function remove_PKCS1_padding($data, $blocksize)
    {
        assert(strlen($data) == $blocksize);
        $data = substr($data, 1);
        if ($data[0] == '\\0') {
            die("Block type 0 not implemented.");
        }
        assert($data[0] == "" || $data[0] == "");
        $offset = strpos($data, "", 1);
        return substr($data, $offset + 1);
    }
    function remove_KYP_padding($data, $blocksize)
    {
        assert(strlen($data) == $blocksize);
        $offset = strpos($data, "");
        return substr($data, 0, $offset);
    }
    function binary_to_number($data)
    {
        $base = "256";
        $radix = "1";
        $result = "0";
        for ($i = strlen($data) - 1; $i >= 0; $i--) {
            $digit = ord($data[$i]);
            $part_res = bcmul($digit, $radix);
            $result = bcadd($result, $part_res);
            $radix = bcmul($radix, $base);
        }
        return $result;
    }
    function number_to_binary($number, $blocksize)
    {
        $base = "256";
        $result = "";
        $div = $number;
        while ($div > 0) {
            $mod = bcmod($div, $base);
            $div = bcdiv($div, $base);
            $result = chr($mod) . $result;
        }
        return str_pad($result, $blocksize, "", STR_PAD_LEFT);
    }
}
