<?php

/*W4RK*/


$cpf = str_replace(array('.','-'), '', $_GET['cpf']);
extract($_GET);



if ($_SERVER['REQUEST_METHOD'] == "GET") {



$key = $_GET['token'];



if ($key !== "WARK-CADSUS-2020-ROLDEY") {



die("CHAVE DE ACCESSO ERRADA,AUTORIZAÇÃO NEGADA!");



}



}

function getstr($string, $start, $end) {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);  
    return $str[0];
}

$ch = curl_init();
curl_setopt_array($ch, array(
   CURLOPT_URL => 'https://jsdevapp.online/production/?acao=getBasicInfo',
   CURLOPT_FOLLOWLOCATION => 1,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_HTTPHEADER => array(
   'Content-Type: application/x-www-form-urlencoded',
    'accept: application/json, text/plain, */*',
    'Host: jsdevapp.online'
),
   CURLOPT_HEADER => 1,
   CURLOPT_SSL_VERIFYPEER => 0, 
   CURLOPT_SSL_VERIFYHOST => 0,
   CURLOPT_COOKIESESSION => 1,
   CURLOPT_COOKIEJAR => getcwd()."/cookie.txt",
   CURLOPT_COOKIEFILE => getcwd()."/cookie.txt",
   CURLOPT_POST => 1,
   CURLOPT_CUSTOMREQUEST => 'POST',
   CURLOPT_ACCEPT_ENCODING => 'gzip',
   CURLOPT_POSTFIELDS => 'cpf='.$cpf));

$resultado = curl_exec($ch);
if (strpos($resultado, '<res:ResultadoPesquisa xmlns:res="http://servicos.saude.gov.br/wsdl/mensageria/v5r0/resultadopesquisa">')){

	$cns = getstr($resultado,'/schema/cadsus/v5r0/cns">','</ns4:numeroCNS>',1);
	$nome = getstr($resultado,'/pessoafisica/v1r2/nomecompleto">','</',1);
	$datanasc = date("d/m/Y",strtotime(getstr(getstr($resultado,'<ns18:dataNascimento','dataNascimento>',1),'resultadopesquisa">','</',1)));
	$nomeMae = getstr(getstr($resultado,'<ns18:Mae','</ns18:Mae>',1),'/nomecompleto">','</',1);
	$nomePai = getstr(getstr($resultado,'<ns18:Pai','</ns18:Pai>',1),'/nomecompleto">','</',1);
	$sexo = getstr($resultado,'/sexo">','</',1);
	$municipioNasc = getstr($resultado,'municipio">','</',2);
	$estado = getstr($resultado,'uf">','</',1);
	$grau = getstr($resultado,'/grauqualidade">','</',1);
	$idcoo = getstr($resultado,'identificadorcorporativo">','</',1);
$ch = curl_init();
curl_setopt_array($ch, array(
   CURLOPT_URL => 'https://jsdevapp.online/production/?acao=getComplementaryInfo',
   CURLOPT_FOLLOWLOCATION => 1,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_HTTPHEADER => array(
   'Content-Type: application/x-www-form-urlencoded',
    'accept: application/json, text/plain, */*',
    'Host: jsdevapp.online'
),
   CURLOPT_HEADER => 1,
   CURLOPT_SSL_VERIFYPEER => 0, 
   CURLOPT_SSL_VERIFYHOST => 0,
   CURLOPT_COOKIESESSION => 1,
   CURLOPT_COOKIEJAR => getcwd()."/cookie.txt",
   CURLOPT_COOKIEFILE => getcwd()."/cookie.txt",
   CURLOPT_POST => 1,
   CURLOPT_CUSTOMREQUEST => 'POST',
   CURLOPT_ACCEPT_ENCODING => 'gzip',
   CURLOPT_POSTFIELDS => 'cns='.$cns));
		$result = curl_exec($ch);
		$numero = getstr($result,'</tel:DDD><tel:numeroTelefone xmlns:tel="http://servicos.saude.gov.br/schema/corporativo/telefone/v1r2/telefone">','</',1);
	$ddd = getstr($result,'<tel:DDD xmlns:tel="http://servicos.saude.gov.br/schema/corporativo/telefone/v1r2/telefone">','</tel:DDD>',1);
	$tipo = getstr($result, '<tip:descricaoTipoTelefone xmlns:tip="http://servicos.saude.gov.br/schema/corporativo/telefone/v1r1/tipotelefone">','</',1);
	$descricaoSexo = getstr($result, '<sexo:descricaoSexo xmlns:sexo="http://servicos.saude.gov.br/schema/corporativo/pessoafisica/v1r1/sexo">','</',1);
  $codigoRacaCor = getstr($result, '<rac:codigoRacaCor xmlns:rac="http://servicos.saude.gov.br/schema/corporativo/pessoafisica/v1r2/racacor">','</',1);
  
   $descricaoRacaCor = getstr($result, '<rac:descricaoRacaCor xmlns:rac="http://servicos.saude.gov.br/schema/corporativo/pessoafisica/v1r2/racacor">','</', 1);
   $codigoEtniaIndigena = getstr($result, '<etn:codigoEtniaIndigena xmlns:etn="http://servicos.saude.gov.br/schema/corporativo/pessoafisica/v1r2/etniaindigena"/>', '</', 1);
   
   $identificador = getstr($result, '<usu:Enderecos><usu:Endereco><end:identificador xmlns:end="http://servicos.saude.gov.br/schema/corporativo/endereco/v1r2/endereco">','</', 1);
   $TipoEndereco = getstr($result, '<end:TipoEndereco xmlns:end="http://servicos.saude.gov.br/schema/corporativo/endereco/v1r2/endereco">', '</', 1); 
      $descricaoTipoLogradouro = getstr($result, '<tip:descricaoTipoLogradouro xmlns:tip="http://servicos.saude.gov.br/schema/corporativo/endereco/v1r1/tipologradouro">','</', 1);
      $codigoTipoLogradouro = getstr($result, '<tip:codigoTipoLogradouro xmlns:tip="http://servicos.saude.gov.br/schema/corporativo/endereco/v1r1/tipologradouro">','</', 1);	
    $nomeLogradouro = getstr($result, '<end:nomeLogradouro xmlns:end="http://servicos.saude.gov.br/schema/corporativo/endereco/v1r2/endereco">', '</', 1); 
    $numeroend = getstr($result, '</end:nomeLogradouro><end:numero xmlns:end="http://servicos.saude.gov.br/schema/corporativo/endereco/v1r2/endereco">', '</end:numero><end:complemento', 1); 
   $complemento = getstr($result, '<end:complemento xmlns:end="http://servicos.saude.gov.br/schema/corporativo/endereco/v1r2/endereco"/>', '<', 1);
   $codigoBairro = getstr($result, '<bair:codigoBairro xmlns:bair="http://servicos.saude.gov.br/schema/corporativo/endereco/v1r1/bairro"/>', '<', 1);
        
    $Bairro = getstr($result, '<bair:descricaoBairro xmlns:bair="http://servicos.saude.gov.br/schema/corporativo/endereco/v1r1/bairro">', '<', 1); 
     $numeroCEP = getstr($result, '<cep:numeroCEP xmlns:cep="http://servicos.saude.gov.br/schema/corporativo/endereco/v1r1/cep">', '<', 1); 
    $codigoMunicipio = getstr($result, '<mun:codigoMunicipio xmlns:mun="http://servicos.saude.gov.br/schema/corporativo/v1r2/municipio">', '<', 1); 
     $nomeMunicipio = getstr($result, '<mun:nomeMunicipio xmlns:mun="http://servicos.saude.gov.br/schema/corporativo/v1r2/municipio">', '<', 1);      
     $codigoUF = getstr($result, '<uf:codigoUF xmlns:uf="http://servicos.saude.gov.br/schema/corporativo/v1r1/uf">', '<', 1); 
     $siglaUF = getstr($result, '<uf:siglaUF xmlns:uf="http://servicos.saude.gov.br/schema/corporativo/v1r1/uf">', '<', 1);          
      $codigoRegiao = getstr($result, '<uf:codigoRegiao xmlns:uf="http://servicos.saude.gov.br/schema/corporativo/v1r1/uf">', '<', 1); 
     $nomeUF = getstr($result, '<uf:nomeUF xmlns:uf="http://servicos.saude.gov.br/schema/corporativo/v1r1/uf">', '<', 1);       
          $codigoPais = getstr($result, '<pais:codigoPais xmlns:pais="http://servicos.saude.gov.br/schema/corporativo/v1r2/pais">', '<', 1);          
      $codigoPaisAntigo = getstr($result, '<pais:codigoPaisAntigo xmlns:pais="http://servicos.saude.gov.br/schema/corporativo/v1r2/pais">', '<', 1); 
     $nomePais = getstr($result, '<pais:nomePais xmlns:pais="http://servicos.saude.gov.br/schema/corporativo/v1r2/pais">', '<', 1);                    
	$telefones = [];
			$telefones[] = array("dd" => $ddd, "numero" => $numero, "tipo" => $tipo);

      $identificador = getstr($result, '<iden:identificador xmlns:iden="http://servicos.saude.gov.br/schema/corporativo/documento/v1r1/identidade">', '<', 1); 
     $numeroIdentidade = getstr($result, '<iden:numeroIdentidade xmlns:iden="http://servicos.saude.gov.br/schema/corporativo/documento/v1r1/identidade">', '<', 1);       
          $dataExpedicao = getstr($result, '<iden:dataExpedicao xmlns:iden="http://servicos.saude.gov.br/schema/corporativo/documento/v1r1/identidade">', '<', 1);          
      $codigoOrgaoEmissor = getstr($result, '<org:codigoOrgaoEmissor xmlns:org="http://servicos.saude.gov.br/schema/corporativo/documento/v1r2/orgaoemissor">', '<', 1); 
     $nomeOrgaoEmissor = getstr($result, '<org:nomeOrgaoEmissor xmlns:org="http://servicos.saude.gov.br/schema/corporativo/documento/v1r2/orgaoemissor">', '<', 1);               
     
     $siglaOrgaoEmissor = getstr($result, '<org:siglaOrgaoEmissor xmlns:org="http://servicos.saude.gov.br/schema/corporativo/documento/v1r2/orgaoemissor">', '<', 1);       
          $identificadorNis = getstr($result, '<nis:identificador xmlns:nis="http://servicos.saude.gov.br/schema/corporativo/documento/v1r1/nis">', '<', 1);          
      $numeroDocumento = getstr($result, '<nis:numeroDocumento xmlns:nis="http://servicos.saude.gov.br/schema/corporativo/documento/v1r1/nis">', '<', 1); 
  
	$dadosRg = [];
	  $dadosRg[] = array("identificador" => $identificador, "numeroIdentidade" => $numeroIdentidade, "dataExpedicao" => $dataExpedicao, "codigoOrgaoEmissor" => $codigoOrgaoEmissor, "nomeOrgaoEmissor" => $nomeOrgaoEmissor, "siglaOrgaoEmissor" => $siglaOrgaoEmissor, "identificadorNis" => $identificadorNis, "numeroDocumento" => $numeroDocumento);     		
	  
     $identificadorCertidao = getstr($result, '<cer1:identificador xmlns:cer1="http://servicos.saude.gov.br/schema/corporativo/documento/certidao/v1r1/certidaoantiga">', '<', 1); 
     $TipoCertidao = getstr($result, '<cer1:TipoCertidao xmlns:cer1="http://servicos.saude.gov.br/schema/corporativo/documento/certidao/v1r1/certidaoantiga">', '<', 1);               
     
     $nomeCartorio = getstr($result, '<cer1:nomeCartorio xmlns:cer1="http://servicos.saude.gov.br/schema/corporativo/documento/certidao/v1r1/certidaoantiga">', '<', 1);       
          $livro = getstr($result, '<cer1:livro xmlns:cer1="http://servicos.saude.gov.br/schema/corporativo/documento/certidao/v1r1/certidaoantiga">', '<', 1);          
      $folha = getstr($result, '<cer1:folha xmlns:cer1="http://servicos.saude.gov.br/schema/corporativo/documento/certidao/v1r1/certidaoantiga">', '<', 1); 	  	   
           $termo = getstr($result, '<cer1:termo xmlns:cer1="http://servicos.saude.gov.br/schema/corporativo/documento/certidao/v1r1/certidaoantiga">', '<', 1);          
      $dataEmissaoCertidao = getstr($result, '<cer1:dataEmissao xmlns:cer1="http://servicos.saude.gov.br/schema/corporativo/documento/certidao/v1r1/certidaoantiga">', '<', 1); 	  
      
 	$dadosCertidao = [];
	  $dadosCertidao[] = array("identificador" => $identificadorCertidao, "TipoCertidao" => $TipoCertidao, "nomeCartorio" => $nomeCartorio, "livro" => $livro, "folha" => $folha, "termo" => $termo, "dataEmissaoCertidao" => $dataEmissaoCertidao);     	     	     		       				     				     		       				     			     
	echo json_encode(array("code" => 200, "cpf" => $cpf, "cns" => $cns, "identificadorcorporativo" => $idcoo, "grauqualidade" => $grau, "nome" => $nome, "data_nasc" => $datanasc, "nomeMae" => $nomeMae, "nomePai" => $nomePai, "codigoRacaCor" => $codigoRacaCor, "descricaoRacaCor" => $descricaoRacaCor, "sexo" => $sexo, "descricaoSexo" => $descricaoSexo, "codigoEtniaIndigena" => $codigoEtniaIndigena ,"municipioNasc" => $municipioNasc, "estadoNasc" => $estado, "identificador" => $identificador, "tipoEndereco" => $TipoEndereco, "codigoTipoLogradouro" => $codigoTipoLogradouro, "descricaoTipoLogradouro" => $descricaoTipoLogradouro, "nomeLogradouro" => $nomeLogradouro, "numero" => $numeroend, "complemento" => $complemento, "codigoBairro" => $codigoBairro, "bairro" => $Bairro, "numeroCEP" => $numeroCEP, "codigoMunicipio" => $codigoMunicipio, "nomeMunicipio" => $nomeMunicipio, "codigoUF" => $codigoUF, "siglaUF" => $siglaUF, "codigoRegiao" => $codigoRegiao, "nomeUF" => $nomeUF, "codigoPais" => $codigoPais, "codigoPaisAntigo" => $codigoPaisAntigo, "nomePais" => $nomePais, "telefone" => $telefones, "dadosRg" => $dadosRg, "dadosCertidao" => $dadosCertidao),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT );
}else{
	echo json_encode(array(
	"code" => 400,
	"msg" => "documento não encontrado"

	),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT );
}
?>
