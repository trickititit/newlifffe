<?php

namespace App\Repositories;

use Config;

abstract class Repository {
	
	protected $model = FALSE;
	
	
	public function get($select = '*',$take = FALSE,$pagination = FALSE, $where = FALSE, $count = FALSE, $order = FALSE) {
		
		$builder = $this->model->select($select);
		
		if($take) {
			$builder->take($take);
		}
		
		if($where) {
			$builder->where($where[0],$where[1]);
		}

        if ($order) {
	        if ($order == "pricedesc") {
	            $order = array("price", "desc");
	        } 
            if (is_array($order)) {
                $builder->orderBy($order[0], $order[1]);
            } else {
                $builder->orderBy($order);
            }
        }

		if($pagination) {
			// Сдедать настройки
			return $this->check($builder->paginate($pagination));
		}
		
		if($count) {
			return $builder->count();
		}

		return $builder->get();

	}

	public function getMaxId() {

		$builder = $this->model->select("id");

		$builder->max("id");
		
		return $builder->first()->id;

	}
	
	public function destroy($id, $model_soft = false) {
		if($model_soft) {
			$result = $this->model->find($id)->forceDelete();
		} else {
			$result = $this->model->find($id)->delete();
		}		
		return $result;
	}
	
	protected function check($result) {
		
		if($result->isEmpty()) {
			return FALSE;
		}
		
		$result->transform(function($item,$key) {
			
			if(is_string($item->img) && is_object(json_decode($item->img)) && (json_last_error() == JSON_ERROR_NONE)) {
				$item->img = json_decode($item->img);
			}

			return $item;
			
		});
		
		return $result;
		
	}
	
	public function one($alias,$attr = array()) {
		$result = $this->model->where('alias',$alias)->first();
		
		return $result;
	}
	
	public function transliterate($string) {
		$str = mb_strtolower($string, 'UTF-8');
		
		$leter_array = array(
			'a' => 'а',
			'b' => 'б',
			'v' => 'в',
			'g' => 'г,ґ',
			'd' => 'д',
			'e' => 'е,є,э',
			'jo' => 'ё',
			'zh' => 'ж',
			'z' => 'з',
			'i' => 'и,і',
			'ji' => 'ї',
			'j' => 'й',
			'k' => 'к',
			'l' => 'л',
			'm' => 'м',
			'n' => 'н',
			'o' => 'о',
			'p' => 'п',
			'r' => 'р',
			's' => 'с',
			't' => 'т',
			'u' => 'у',
			'f' => 'ф',
			'kh' => 'х',
			'ts' => 'ц',
			'ch' => 'ч',
			'sh' => 'ш',
			'shch' => 'щ',
			'' => 'ъ',
			'y' => 'ы',
			'' => 'ь',
			'yu' => 'ю',
			'ya' => 'я',
		);
		
		foreach($leter_array as $leter => $kyr) {
			$kyr = explode(',',$kyr);			
			$str = str_replace($kyr,$leter, $str);			
		}
		
		//  A-Za-z0-9-
		$str = preg_replace('/(\s|[^A-Za-z0-9\-])+/','_',$str);		
		$str = trim($str,'-');		
		return $str;
	}
	
	
	
}

?>