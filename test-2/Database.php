<?php

class Database
{
	public $connection;
	public static function connectDB()
	{
		return new mysqli("localhost","root","","test-2");
	}
}
