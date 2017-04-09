<?php
class UserModel extends Model
{
    public function reg($arr)
    {
        $sql = "INSERT INTO user(username,pwd,face,email,phone,crtime) 
        values(:username,:pwd,:face,:email,:phone,:crtime)";
        /*echo "<pre>";
        print_r($arr);
        die;*/
        //参数传递
        $params = array();
        foreach($arr as $key=>$value)
        {
            $params[':'.$key] = $value;
        }
        //print_r($params);die;
        return $this->add($sql,$params);
    }

    //验证用户名和密码是否正确
    public function loginCheck($arr)
    {
        $name = $arr['name'];//name可能是用户名，可能是邮箱，可能是手机
        //先查一个，比如根据用户名、邮箱、电话查询结果，根据查询的结果，再比对密码是否正确
        $sql = "SELECT id,username,pwd FROM user WHERE username='$name' OR email='$name' OR phone='$name'";
        //调用方法，获得一行查询结果
        $row = $this->find($sql);
        /*echo "<pre>";
        print_r($row);
        echo "</pre>";
        echo $row['pwd']."<br>";
        echo $arr['pwd'];
        die;*/
        if($row['pwd'] == $arr['pwd'] )
        {
            //return $row['username'];//为了存session
            return $row;//为了存session
        }else
        {
            return false;
        }
    }

    //激活方法
    public function jihuo($code)
    {
        $code = base64_decode($code);
        //echo $code;
        //将激活信息分割成数组
        $info = explode(',',$code);
        //得到info数组，下标为1的是创建时间，下标为2的是注册的邮箱
        //根据邮箱来激活该用户，即，根据邮箱修改is_jihuo字段的值为1
        $sql = "update user set is_jihuo = 1 where email = '$info[2]'";
        return $this->save($sql);
    }
}