<?php
	/** View Class [HELPER MVC]
	* Responsavel por carregar o template, povoar e exibir a view, povoar e incluir arquivos php no sistem.
	* Arquitetura MVC!
	*
	* @copyright (c) 2017, Thiago Dias
	*/
	class View{
		private static $Data;
		private static $Keys;
		private static $Values;
		private static $Template;

		public static function Load($Template){
			self::$Template = (string)$Template;
			self::$Template = file_get_contents(self::$Template . '.tpl.html');
			var_dump(self::$Template);
		}

		public static function Show(array $Data){
			self::setKeys($Data);
			self::setValues();
			self::showView();
		}

		public static function Request($File, array $Data){
			extract($Data);
			require("{$File}.inc.php");
		}

		//PRIVATES 

		private static function setKeys($Data){
			self::$Data = $Data;
			self::$Keys = explode('&','#' . implode('#&#',array_keys(self::$Data)) . '#');
			//var_dump(self::$Keys);
		}
		private static function setValues(){
			self::$Values = array_values(self::$Data);
		}

		private static function showView(){
			echo str_replace(self::$Keys, self::$Values, self::$Template);
		}
	}

?>