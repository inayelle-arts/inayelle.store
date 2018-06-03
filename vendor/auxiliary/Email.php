<?php

namespace vendor\auxiliary;

class Email
{
	private $receiver;
	private $subject;
	private $message;
	
	/**
	 * Email constructor.
	 *
	 * @param $receiver
	 * @param $subject
	 * @param $message
	 */
	public function __construct( string $receiver, string $subject, string $message )
	{
		$this->receiver = $receiver;
		$this->subject  = $subject;
		$this->message  = $message;
	}
	
	public function send() : bool
	{
		return mail($this->receiver, $this->subject, $this->message);
	}
}