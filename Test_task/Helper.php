<?php

	abstract class Helper
	{
		static function myDump($var, $mode = 'p')
		{
			if ($mode != 'p' && $mode != 'e' && $mode != 'd' && $mode != 'm'){
				echo "Извините, вы не правильно задали режим:<br/>
				'p' - для print_r() - По умолчанию;<br/>
				'e' - для var_export();<br/>
				'd' - для var_dump());<br/>";
				return;
			}
			else if ($mode == 'p') {
				echo '<pre>';
				print_r($var);
				echo '</pre>';
				return;
			}
			else if ($mode == 'e'){
				echo '<pre>';
				var_export($var);
				echo '</pre>';
				return;
			}
			else if ($mode == 'm') {
				$str = '[';
				$total = count($var);
				$counter = 1;
				foreach ($var as $value) {
					if ($counter == $total) {
						$str .= " $value];";
					} else {
						$str .= " $value,";	
					}
					$counter++;
				}
				echo $str;
				return;
			}
			else {
				echo '<pre>';
				var_dump($var);
				echo '</pre>';
				return;
			}
		}
	}