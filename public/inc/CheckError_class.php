<?php
class CheckError {

    var $value;        //チェック対象値
    var $name;        //項目名
    var $ary;        //エラー種別及びパラメータを格納した2次元配列
/*==================================
    エラーメッセージ
==================================*/
    var $msg1 = "_VAR_は必須項目です。<br>";
    var $msg2 = "_VAR_は_MAX_文字以下で入力してください。<br>";
    var $msg3 = "_VAR_は_MIN_文字以上で入力してください。<br>";
    var $msg4 = "_VAR_は_MIN_以上_MAX_以下で入力してください。<br>";
    var $msg5 = "_VAR_は半角文字で入力してください。<br>";
    var $msg6 = "_VAR_は全角文字で入力してください。<br>";
    var $msg7 = "_VAR_は半角数字で入力してください。<br>";
    var $msg8 = "_VAR_は全角ひらがなで入力してください。<br>";
    var $msg9 = "_VAR_は全角カタカナで入力してください。<br>";
    var $msg10 = "_VAR_には「< > \" \' & 」を入力できません。<br>";
    var $msg11 = "_VAR_の形式がちがいます。<br>";
    var $msg12 = "メールアドレスの形式がちがいます。<br>";
    var $msg13 = "_VAR_は半角英数字で入力してください。<br>";
    
    //コンストラクタ
    function CheckError($value, $name, $ary) {
        $this->name = $name;
        $this->ary = $ary;
        //magic_quotes_gpcがONの時アンクォート
        $value = $this->gpc_stripslash($value);    
        //両端の空白(全･半角)を除く
        $this->value = $this->mb_trim(trim($value));
    }

/*==================================
    エラーチェック
===================================*/                    
    function checkErrorAll() {
        for ($i=0; $i<count($this->ary); $i++) {
            switch ($this->ary[$i][0]) {
                case "empty" :
                    if (!$this->emptyCheck($this->value)) {
                        return str_replace("_VAR_", $this->name, $this->msg1);
                    }
                    break;
                case "max" :
                    if (!$this->maxCheck($this->value, $this->ary[$i][1])) {
                        $msg = str_replace("_VAR_", $this->name, $this->msg2);
                        return str_replace("_MAX_", $this->ary[$i][1], $msg);
                    }
                    break;
                case "maxZen" :    
                    if (!$this->maxZenCheck($this->value, $this->ary[$i][1])) {
                        $msg = str_replace("_VAR_", $this->name, $this->msg2);
                        return str_replace("_MAX_", $this->ary[$i][1], $msg);
                    }
                    break;
                case "min" :
                    if (!$this->minCheck($this->value, $this->ary[$i][1])) {
                        $msg = str_replace("_VAR_", $this->name, $this->msg3);
                        return str_replace("_MIN_", $this->ary[$i][1], $msg);
                    }
                    break;
                case "minZen" :    
                    if (!$this->minZenCheck($this->value, $this->ary[$i][1])) {
                        $msg = str_replace("_VAR_", $this->name, $this->msg3);
                        return str_replace("_MIN_", $this->ary[$i][1], $msg);
                    }
                    break;
                case "range" :    
                    if (!$this->rangeCheck($this->value, $this->ary[$i][1], $this->ary[$i][2])) {
                        $msg = str_replace("_VAR_", $this->name, $this->msg4);
                        $msg = str_replace("_MIN_", $this->ary[$i][1], $msg);
                        return str_replace("_MAX_", $this->ary[$i][2], $msg);
                    }
                    break;
                case "han" :
                    if (!$this->hanCheck($this->value)) {
                        return str_replace("_VAR_", $this->name, $this->msg5);
                    }
                    break;
                case "zen" :    
                    if (!$this->zenCheck($this->value)) {
                        return str_replace("_VAR_", $this->name, $this->msg6);
                    }
                    break;
                case "num" :    
                    if (!$this->numCheck($this->value)) {
                        return str_replace("_VAR_", $this->name, $this->msg7);
                    }
                    break;
                case "hkana" :    
                    if (!$this->hkanaCheck($this->value)) {
                        return str_replace("_VAR_", $this->name, $this->msg8);
                    }
                    break;
                case "kkana" :    
                    if (!$this->kkanaCheck($this->value)) {
                        return str_replace("_VAR_", $this->name, $this->msg9);
                    }
                    break;
                case "NGchar" :    
                    if (!$this->NGcharCheck($this->value)) {
                        return str_replace("_VAR_", $this->name, $this->msg10);
                    }
                    break;
                case "ptn" :    
                    if (!$this->ptnCheck($this->value, $this->ary[$i][1])) {
                        return str_replace("_VAR_", $this->name, $this->msg11);
                    }
                    break;
                case "email" :
                    if (!$this->emailCheck($this->value)) {
                        return  $this->msg12;
                    }
                    break;
                case "hunnum" :
                    if (!$this->hannumCheck($this->value)) {
                        return  $this->msg13;
                    }
                    break;
            }
        }
        return "";    
    }    
/*==================================
    必須チェック
==================================*/
    function emptyCheck($value) {
        if (strlen($value)) {
            return true;
        } else {
            return false;
        } 
    }
/*================================
    Maxチェック(半角)
      引数 $max:最大値
==================================*/
    function maxCheck($value, $max) {
        //スペースの場合はそのままリターン
        if (!strlen($value)) {
            return true;
        }
         
        if (strlen($value) > intval($max) ) {
            return false;
        } else {
            return true;
        }
    }
/*================================
    Maxチェック(全角)
      引数 $max:最大値
==================================*/
    function maxZenCheck($value, $max) {
        //スペースの場合はそのままリターン
        if (!strlen($value)) {
            return true;
        }
         
        if (mb_strlen($value,"UTF-8") > intval($max)) {
            return false;
        } else {
            return true;
        }
    }
/*================================
    Minチェック(半角)
      引数 $max:最大値
==================================*/
    function minCheck($value, $min) {
        //スペースの場合はそのままリターン
        if (!strlen($value)) {
            return true;
        }
         
        if (strlen($value) < intval($min) ) {
            return false;
        } else {
            return true;
        }
    }
/*================================
    Minチェック(全角)
      引数 $min:最大値
==================================*/
    function minZenCheck($value, $min) {
        //スペースの場合はそのままリターン
        if (!strlen($value)) {
            return true;
        }
         
        if (mb_strlen($value,"UTF-8") < intval($min)) {
            return false;
        } else {
            return true;
        }
    }
/*================================
    数値範囲チェック
==================================*/
function rangeCheck($value, $min, $max) {
        //スペースの場合はそのままリターン
        if (!strlen($value)) {
            return true;
        }
         
    if (!is_numeric($value)) {
        return false;
    }
    
    if ( intval($value) < intval($min) || intval($value) > intval($max)) {
        return false;
    } else {
        return true;
    }        
}
/*================================
    半角文字チェック
==================================*/
    function hanCheck($value) {
        //スペースの場合はそのままリターン
        if (!strlen($value)) {
            return true;
        }
         
        if (strlen($value) == mb_strlen($value,"UTF-8")) {
            return true;
        } else {
            return false;
        }

    }
/*================================
    全角文字チェック
==================================*/
    function zenCheck($data) {
        //スペースの場合はそのままリターン
        if (!strlen($value)) {
            return true;
        }
         
        if (strlen($data) == mb_strlen($data) * 2) {
            return true;
        } else {
            return false;
        }
    }
/*================================
    半角数字チェック
==================================*/
    function numCheck($data) {
        //スペースの場合はそのままリターン
        if (!strlen($data)) {
            return true;
        }
         
        if (ereg("^[0-9]+$", $data)) {
            return true;
        } else {
            return false;
        }
    }

/*================================
    半角英数字チェック
==================================*/
    function hannumCheck($value) {
        //スペースの場合はそのままリターン
        if (!strlen($value)) {
            return true;
        }
         
        $pat = "^[0123456789aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ]+$";   
        if (mb_ereg_match($pat, $this->value)) {
            return true;
        } else {
            return false;
        }
    }

/*================================
    全角ひらがなチェック
==================================*/
    function hkanaCheck($value) {
        //スペースの場合はそのままリターン
        if (!strlen($value)) {
            return true;
        }
         
        $pat = "^[ぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑをん?゛゜ゝゞー－・　 ]+$";   
        if (mb_ereg_match($pat, $this->value)) {
            return true;
        } else {
            return false;
        }
    }

/*================================
    全角カタカナチェック
==================================*/
    function kkanaCheck($value) {
        //スペースの場合はそのままリターン
        if (!strlen($value)) {
            return true;
        }
         
        $pat = "^[ァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲン？゛゜ゝゞー－・]+$";   
        if (mb_ereg_match($pat, $this->value)) {
            return true;
        } else {
            return false;
        }
    }

/*================================
    禁止文字チェック
==================================*/
    function NGcharCheck($value) {
        //スペースの場合はそのままリターン
        if (!strlen($value)) {
            return true;
        }
         
        if (ereg("[<>\"\'&]", $this->value)) {
            return false;
        } else {
            return true;
        }
    }
/*================================
    形式チェック
      引数 $ptn:パターン
==================================*/
    function ptnCheck($data, $ptn) {
        //スペースの場合はそのままリターン
        if (!strlen($value)) {
            return true;
        }
         
        if (!ereg($ptn, $data)) {
            return false;
        } else {
            return true;
        }
    }
/*================================
    Eメールチェック
==================================*/
    function emailCheck($data) {
        //スペースの場合はそのままリターン
        if (!strlen($data)) {
            return true;
        }
        //半角文字か？ 
        if (!$this->hanCheck($data)) {
            return false;
        }
        //@が1つだけ存在？
        if (substr_count($data, "@") != 1) {
            return false;
        }
        
        $len = strlen($data);          //文字列長
        $pos = strpos($data,"@");    //@の位置
        //@が先頭または末尾か？    
        if ($pos == 0 || $pos == ($len - 1) ) {
            return false;
        }
        //@の後に"."が1つ以上あるか？
        $str_tmp = substr($data, $pos);
        if (substr_count($str_tmp, ".") < 1) {
            return false;
        }
        //"."が先頭または末尾か？
        if (strpos($data, ".") == 0 || strrpos($data, ".") == ($len - 1)) {    
            return false;
        }
        //".@", "@.", ".." が存在するか？
        if (strpos($data, ".@") != false || strpos($data, "@.") != false || strpos($data, "..") != false) {    
            return false;
        }
        return true;                            
    }
    
////////// 文字列操作　関数 /////////////////
/*==================================
    SQLアンエスケープ
==================================*/
    function gpc_stripslash($str) {
        //magic_quotes_gpcがONの時アンクォート
        if (get_magic_quotes_gpc() == 1) {    
            return stripslashes($str);
        } else {
            return $str;
        }
    }
/*==================================
    両トリム(全角スペース用)
==================================*/
    function mb_trim($str) {
        return $this->mb_Rtrim($this->mb_Ltrim($str));
    }
/*==================================
    左トリム(全角スペース用)
==================================*/
    function mb_Ltrim($str) {
        return mb_ereg_replace("^　+", "", $str);
    }
/*==================================
    右トリム(全角スペース用)
==================================*/
    function mb_Rtrim($str) {
        return mb_ereg_replace("　+$", "", $str);
    }
}    

?>
