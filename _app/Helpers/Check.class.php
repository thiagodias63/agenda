<?php
/**
 *
 */
class Check{
	private static $Data;
	private static $Format;

	public static function Email($Email){
		self::$Data = (string) $Email;
		self::$Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

		if(preg_match(self::$Format, self::$Data)):
			return true;
		else:
			return false;
		endif;
	}
  	public static function Name($Name){
  		self::$Format = array();
  		self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
  		self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
  		self::$Data = strtr(utf8_decode($Name), utf8_decode(self::$Format['a']), self::$Format['b']);
  		self::$Data = strip_tags(trim(self::$Data));
  		self::$Data = str_replace(' ', '-', self::$Data);
  		self::$Data = str_replace(array('-----','----','---','--'), '-', self::$Data);

  		return strtolower(utf8_encode(self::$Data));
  	}

  	public static function Date($Date){
  		self::$Format = explode(' ',$Date);
  		self::$Data = explode('/',self::$Format[0]);

  		if(empty(self::$Format[1])):
  			self::$Format[1] = date('H:i:s');
  		endif;

  		self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0] . ' ' . self::$Format[1];
  		return self::$Data;
  	}

  	public static function Words($String, $Limit, $Pointer = null){
  		self::$Data = strip_tags(trim($String));
  		self::$Format = (int) $Limit;

  		$ArrWords = explode(' ',self::$Data);
  		$NumWords = count($ArrWords);
  		$NewWords = implode(' ',array_slice($ArrWords, 0, self::$Format));

  		$Pointer = (empty($Pointer) ? '...' : ' ' . $Pointer);
  		$Result = (self::$Format < $NumWords ? $NewWords . $Pointer : self::$Data);

  		return $Result;
  	}

  	public static function CatByName($CategoriaNome){
  		$read = new Read;
  		$read->ExeRead('gems','WHERE nome_gems = :nome',"nome={$CategoriaNome}");
  		if($read->getRowCount()):
  			return $read->getResult()[0]['id_gems'];
  		else:
  			echo "A categoria {$CategoriaNome} não foi encontrada";
  			die;
  		endif;
  	}

  	public static function UserOnline() {
  		$now = date('Y-m-d H:i:s');
  		$deleteUserOnline = new Delete;
  		$deleteUserOnline->ExeDelete('userOnline','where online_endview < :now','now={$now}');

  		$readUserOnline = new Read;
  		$readUserOnline->ExeRead('userOnline');
  		return $readUserOnline->getRowCount(); // aqui mostra quantos estão online 
  	}

  	public static function Image($ImageUrl, $ImageDesc,$ImageW,$ImageH){
  		self::$Data = '/uploads/' . $ImageUrl;
  		if(file_exists(self::$Data) && !is_dir(self::$Data)):
  			$patch = HOME;
  			$imagem = self::$Data;
  			return "<img src=\"{$patch}/tim.php?src={$patch}/{$imagem}&w={$ImageW}&h={$ImageH}\" alt=\"{$ImageDesc}\" title=\"{$ImageDesc}\" />";

  		endif;

  	}
}
?>