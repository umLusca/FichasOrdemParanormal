<?php

class APIRequisition
{
	public int $status;
	public string $msg;
	public ?array $data;
	
	
	final public function __construct(int $status = 404, string $message = "Requisição não encontrada", array|null $data = null)
	{
		$this->status = $status;
		$this->msg = $message;
		$this->data = $data;
		
		
	}
	
	final public function setStatus(int $status): void
	{
		$this->status = $status;
	}
	
	final public function setMsg(string $msg): void
	{
		$this->msg = $msg;
	}
	
	final public function setData($data = null): void
	{
		$this->data = $data;
	}
	
	final public function setCustomData(string $key, $data = null): void
	{
		$this->$key = $data;
	}
	
	public function getRequisition(): void {}
	
	public function postRequisition(): void {}
	
	public function putRequisition(): void {}
	
	public function deleteRequisition(): void {}
}

class APIException extends Exception
{
	public string $msg;
	public int $status;
	
	public function __construct(string $message, int $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->msg = $message;
		$this->status = $code;
		
		
	}
}