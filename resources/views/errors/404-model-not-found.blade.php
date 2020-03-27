@extends('errors::illustrated-layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', $message ?? "Zut, une erreur ! Vite retournons à la page d'accueil");
