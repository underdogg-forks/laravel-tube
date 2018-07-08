<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository{

    protected $model;

    public function getAll($columns = ['*']){
        return $this->model->get($columns);
    }

    public function create($data){
        return $this->model->create($data);
    }

    public function update($data,$id){
        return $this->model->where('id','=',$id)->update($data);
    }

    public function findAuth($id){
        return $this->model->where([
            'id' => $id,
            'user_id' => auth()->user()->id
        ])->first();
    }

    public function delete(){
        return $this->model->delete();
    }
	
	public function truncate(){
		return $this->model->truncate();
	}


}