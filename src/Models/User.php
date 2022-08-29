<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $guarded = [];

    private $id;
    private $name;
    private $age;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->attributes['id'];
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->attributes['id'] = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->attributes['name'];
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->attributes['name'] = $name;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->attributes['age'];
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->attributes['age'] = $age;
    }
}