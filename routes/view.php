<?php

Route::get('testPdf', 'GeneralController@createPdf');

Route::get('pdf_nomina', 'ViewFormatController@pdfNomina');
Route::get('view_nomina', 'ViewFormatController@viewNomina');


Route::get('pdf_liquidacion', 'ViewFormatController@viewLiquidacion');
Route::get('view_liquidacion', 'ViewFormatController@viewLiquidacion');

Route::get('view_certificado_salario', 'ViewFormatController@viewCertificadoSalario');
Route::get('view_certificado_tiempo', 'ViewFormatController@viewCertificadoTiempo');
Route::get('view_certificado_devengado', 'ViewFormatController@viewCertificadoDevengado');


Route::post('emailIncapacidades', 'ViewFormatController@viewEmail');


Route::get('DowloadFile', 'ViewFormatController@DowloadFile');