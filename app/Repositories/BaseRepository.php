<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository{

    protected $model;
    
    public function getAll($columns = ['*']){
        return $this->model->get($columns);
    }

    public function getWhere($data){
       return $this->model->where($data)->get();
   
    }

    public function findWhere($data){
        return $this->model->where($data)->first();
    }

    public function create($data){
        return $this->model->create($data);
    }

    public function update($data){
        return $this->model->update($data);
    }

    public function find($id){
        return $this->model->find($id);
    }

    public function findAuth($id){
        return $this->model->where([
            'id' => $id,
            'user_id' => auth()->user()->id
        ])->first();
    }

    public function getAuth(){
        return $this->model->where('user_id','=',auth()->user()->id)->get();
    }

    public function delete($id){
        
        $this->model->where('id','=',$id)->delete();
    }
    
    public function deleteWhere($data){
        foreach($this->model->where($data)->get() as $record){
            $record->delete();
        }
    }
    
	public function truncate(){
		return $this->model->truncate();
	}


}