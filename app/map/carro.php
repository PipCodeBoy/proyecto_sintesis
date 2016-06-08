<?php

	class Carro{
		public $id_carro;
		public $fecha_creacion;
		public $fecha_actualizacion;
		public $detalle=array();

		function __construct($id_carro,$fecha_creacion,$fecha_actualizacion,$detalle){
			$this->id_carro=$id_carro;
			$this->fecha_creacion=$fecha_creacion;
			$this->fecha_actualizacion=$fecha_actualizacion;
			$this->detalle=$detalle;
		}

		
	}