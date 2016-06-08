<?php

	class Detalle_carro{
		public $id_detalle_carro;
		public $producto;	
		public $nombre_producto;
		public $imagen_producto;
		public $cantidad;
		public $precio_unitario;

		function __construct($id_detalle_carro,$producto,$nombre_producto,$imagen_producto,$cantidad,$precio_unitario){
			$this->id_detalle_carro=$id_detalle_carro;
			$this->producto=$producto;
			$this->nombre_producto=$nombre_producto;
			$this->imagen_producto=$imagen_producto;
			$this->cantidad=$cantidad;
			$this->precio_unitario=$precio_unitario;
		}

		
	}