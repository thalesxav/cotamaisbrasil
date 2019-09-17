<?php

    set_time_limit(900);
    ini_set('max_execution_time', 900);

    header('Content-Type: text/html; charset=utf-8');

    require('../Conexao.php');
    require('../Config.php');

    $con = new Conexao();
    $crowler = new Crawler();
    $pagetoken = "";

    $array_estados = array("Acre" => "AC", "Alagoas" => "AL", "Amapá" => "AP", "Amazonas" => "AM",
     "Bahia" => "BA", "Ceará" => "CE", "Distrito Federal" => "DF", "Espírito Santo" => "ES", "Goiás" => "GO",
     "Maranhão" => "MA", "Mato Grosso" => "MT", "Mato Grosso do Sul" => "MS", "Minas Gerais" => "MG",
     "Pará" => "PA", "Paraíba" => "PB", "Paraná" => "PR", "Pernambuco" => "PE", "Piauí" => "PI",
     "Rio de Janeiro" => "RJ", "Rio Grande do Norte" => "RN", "Rio Grande do Sul" => "RS", "Rondônia" => "RO",
     "Roraima" => "RR", "Santa Catarina" => "SC", "São Paulo" => "SP", "Sergipe" => "SE", "Tocantins" => "TO");
    $array_top_cidades = array(/*' São Paulo, São Paulo',' Rio de Janeiro, Rio de Janeiro',
        ' Brasília, Distrito Federal',' Salvador,Bahia',' Fortaleza, Ceará',*/' Belo Horizonte, Minas Gerais',' Manaus, Amazonas',' Curitiba, Paraná',' Recife, Pernambuco',' Goiânia, Goiás',' Belém,Pará',' Porto Alegre, Rio Grande do Sul',' Guarulhos, São Paulo',' Campinas, São Paulo',' São Luís, Maranhão',' São Gonçalo, Rio de Janeiro',' Maceió, Alagoas',' Duque de Caxias, Rio de Janeiro',' Campo Grande, Mato Grosso do Sul',' Natal, Rio Grande do Norte',' Teresina, Piauí',' São Bernardo do Campo, São Paulo',' Nova Iguaçu, Rio de Janeiro',' João Pessoa, Paraíba',' São José dos Campos, São Paulo',' Santo André, São Paulo',' Ribeirão Preto, São Paulo',' Jaboatão dos Guararapes, Pernambuco',' Osasco, São Paulo',' Uberlândia, Minas Gerais',' Sorocaba, São Paulo',' Contagem, Minas Gerais',' Aracaju, Sergipe',' Feira de Santana,Bahia',' Cuiabá, Mato Grosso',' Joinville, Santa Catarina',' Aparecida de Goiânia, Goiás',' Londrina, Paraná',' Juiz de Fora, Minas Gerais',' Ananindeua,Pará',' Porto Velho, Rondônia',' Serra, Espírito Santo',' Niterói, Rio de Janeiro',' Belford Roxo, Rio de Janeiro',' Caxias do Sul, Rio Grande do Sul','Campos dos Goytacazes, Rio de Janeiro',' Macapá, Amapá',' Florianópolis, Santa Catarina',' Vila Velha, Espírito Santo',' Mauá, São Paulo',' São João de Meriti, Rio de Janeiro',' São José do Rio Preto, São Paulo',' Mogi das Cruzes, São Paulo',' Betim, Minas Gerais',' Santos, São Paulo',' Diadema, São Paulo',' Maringá, Paraná',' Jundiaí, São Paulo',' Campina Grande, Paraíba',' Montes Claros, Minas Gerais',' Rio Branco, Acre',' Piracicaba, São Paulo',' Carapicuíba, São Paulo',' Boa Vista, Roraima',' Olinda, Pernambuco',' Anápolis, Goiás',' Cariacica, Espírito Santo',' Bauru, São Paulo',' Itaquaquecetuba, São Paulo',' São Vicente, São Paulo','Vitória, Espírito Santo',' Caucaia, Ceará','Caruaru, Pernambuco',' Blumenau, Santa Catarina',' Franca, São Paulo',' Ponta Grossa, Paraná',' Petrolina, Pernambuco',' Canoas, Rio Grande do Sul',' Pelotas, Rio Grande do Sul',' Vitória da Conquista,Bahia',' Ribeirão das Neves, Minas Gerais',' Uberaba, Minas Gerais',' Paulista, Pernambuco',' Cascavel, Paraná',' Praia Grande, São Paulo',' São José dos Pinhais, Paraná',' Guarujá, São Paulo',' Taubaté, São Paulo',' Petrópolis, Rio de Janeiro',' Limeira, São Paulo',' Santarém,Pará',' Camaçari,Bahia',' Palmas, Tocantins',' Suzano, São Paulo',' Mossoró, Rio Grande do Norte',' Taboão da Serra, São Paulo',' Várzea Grande, Mato Grosso',' Sumaré, São Paulo',' Santa Maria, Rio Grande do Sul',' Gravataí, Rio Grande do Sul',' Governador Valadares, Minas Gerais',' Marabá,Pará',' Juazeiro do Norte, Ceará',' Barueri, São Paulo',' Embu das Artes, São Paulo',' Volta Redonda, Rio de Janeiro',' Ipatinga, Minas Gerais',' Parnamirim, Rio Grande do Norte',' Imperatriz, Maranhão',' Foz do Iguaçu, Paraná',' Macaé, Rio de Janeiro',' Viamão, Rio Grande do Sul',' São Carlos, São Paulo',' Indaiatuba, São Paulo',' Cotia, São Paulo',' Novo Hamburgo, Rio Grande do Sul',' São José, Santa Catarina',' Magé, Rio de Janeiro',' Colombo, Paraná',' Itaboraí, Rio de Janeiro',' Sete Lagoas, Minas Gerais',' Americana, São Paulo',' Marília, São Paulo',' Divinópolis, Minas Gerais',' Itapevi, São Paulo',' São Leopoldo, Rio Grande do Sul',' Araraquara, São Paulo',' Rio Verde, Goiás',' Jacareí, São Paulo',' Rondonópolis, Mato Grosso',' Arapiraca, Alagoas',' Hortolândia, São Paulo',' Presidente Prudente, São Paulo','Maracanaú, Ceará',' Dourados, Mato Grosso do Sul','Chapecó Chapecó, Santa Catarina',' Cabo Frio, Rio de Janeiro',' Itajaí, Santa Catarina',' Santa Luzia, Minas Gerais',' Juazeiro,Bahia',' Criciúma, Santa Catarina',' Itabuna,Bahia',' Águas Lindas de Goiás, Goiás','Rio Grande, Rio Grande do Sul',' Alvorada, Rio Grande do Sul',' Cachoeiro de Itapemirim, Espírito Santo',' Sobral, Ceará',' Luziânia, Goiás',' Parauapebas,Pará',' Cabo de Santo Agostinho, Pernambuco',' Rio Claro, São Paulo',' Angra dos Reis, Rio de Janeiro',' Passo Fundo, Rio Grande do Sul',' Castanhal,Pará',' Lauro de Freitas,Bahia',' Araçatuba, São Paulo',' Ferraz de Vasconcelos, São Paulo',' Santa Bárbara do Oeste, São Paulo',' Nova Friburgo, Rio de Janeiro',' Barra Mansa, Rio de Janeiro',' Nossa Senhora do Socorro, Sergipe',' Teresópolis, Rio de Janeiro',' Guarapuava, Paraná',' Araguaína, Tocantins',' Ibirité, Minas Gerais',' Jaraguá do Sul, Santa Catarina',' São José de Ribamar, Maranhão',' Mesquita, Rio de Janeiro',' Francisco Morato, São Paulo',' Itapecerica da Serra, São Paulo',' Itu, São Paulo',' Linhares, Espírito Santo',' Palhoça, Santa Catarina',' Timon, Maranhão',' Bragança Paulista, São Paulo',' Valparaíso de Goiás, Goiás',' Pindamonhangaba, São Paulo',' Poços de Caldas, Minas Gerais',' Caxias, Maranhão',' Itapetininga, São Paulo',' Nilópolis, Rio de Janeiro',' Ilhéus,Bahia',' Maricá, Rio de Janeiro',' São Caetano do Sul, São Paulo',' Teixeira de Freitas,Bahia',' Camaragibe, Pernambuco',' Abaetetuba,Pará',' Lages, Santa Catarina',' Jequié,Bahia',' Barreiras,Bahia',' Paranaguá, Paraná',' Franco da Rocha, São Paulo',' Parnaíba, Piauí',' Patos de Minas, Minas Gerais','Mogi Guaçu, São Paulo',' Alagoinhas,Bahia',' Pouso Alegre, Minas Gerais',' Rio das Ostras, Rio de Janeiro',' Queimados, Rio de Janeiro',' Jaú, São Paulo',' Porto Seguro,Bahia',' Botucatu, São Paulo','Araucária, Paraná',' Sinop, Mato Grosso',' Atibaia, São Paulo','Balneário Camboriú, Santa Catarina',' Sapucaia do Sul, Rio Grande do Sul','Toledo, Paraná',' Teófilo Otoni, Minas Gerais','Garanhuns, Pernambuco','Santana de Parnaíba, São Paulo','Vitória de Santo Antão, Pernambuco',' Cametá,Pará',' Barbacena, Minas Gerais','Santa Rita, Paraíba',' Sabará, Minas Gerais',' Varginha, Minas Gerais','Apucarana, Paraná',' Brusque, Santa Catarina','Simões Filho,Bahia',' Araras, São Paulo',' Itaguaí, Rio de Janeiro',' Araruama, Rio de Janeiro','Pinhais, Paraná',' Crato, Ceará','Campo Largo, Paraná',' Marituba,Pará',' Resende, Rio de Janeiro',' Cubatão, São Paulo',' São Mateus, Espírito Santo','Santa Cruz do Sul, Rio Grande do Sul','Cachoeirinha, Rio Grande do Sul',' Itapipoca, Ceará',' Valinhos, São Paulo','Maranguape, Ceará',' Ji-Paraná, Rondônia',' Conselheiro Lafaiete, Minas Gerais','São Félix do Xingu,Pará',' Bragança,Pará',' Vespasiano, Minas Gerais',' Trindade, Goiás','Uruguaiana, Rio Grande do Sul',' Sertãozinho, São Paulo',' Jandira, São Paulo',' Guarapari, Espírito Santo','Barcarena,Pará',' Birigui, São Paulo',' Ribeirão Pires, São Paulo','Arapongas, Paraná','Codó, Maranhão',' Colatina, Espírito Santo',' Votorantim, São Paulo','Paço do Lumiar, Maranhão',' Barretos, São Paulo',' Catanduva, São Paulo',' Várzea Paulista, São Paulo',' Guaratinguetá, São Paulo',' Tatuí, São Paulo','Formosa, Goiás',' Caraguatatuba, São Paulo',' Três Lagoas, Mato Grosso do Sul',' Santana, Amapá','Bagé, Rio Grande do Sul',' Itatiba, São Paulo',' Bento Gonçalves, Rio Grande do Sul',' Itabira, Minas Gerais',' Salto, São Paulo','Almirante Tamandaré, Paraná','Paulo Afonso,Bahia',' Poá, São Paulo',' Araguari, Minas Gerais',' Igarassu, Pernambuco','Novo Gama, Goiás',' Ubá, Minas Gerais','Senador Canedo, Goiás',' Passos, Minas Gerais',' Altamira,Pará',' Parintins, Amazonas',' Tucuruí,Pará','Ourinhos, São Paulo','Eunápolis,Bahia',' São Lourenço da Mata, Pernambuco',' Paragominas,Pará','Piraquara, Paraná','Açailândia, Maranhão','Umuarama, Paraná',' Corumbá, Mato Grosso do Sul',' Coronel Fabriciano, Minas Gerais',' Paulínia, São Paulo','Catalão, Goiás',' Muriaé, Minas Gerais','Santa Cruz do Capibaribe, Pernambuco',' Ariquemes, Rondônia','Patos, Paraíba','Cambé, Paraná','Tailândia,Pará',' Araxá, Minas Gerais',' Erechim, Rio Grande do Sul','Tubarão, Santa Catarina','Bacabal, Maranhão','Japeri, Rio de Janeiro','Itumbiara, Goiás',' Ituiutaba, Minas Gerais',' São Pedro da Aldeia, Rio de Janeiro',' Lagarto, Sergipe',' Assis, São Paulo','Lavras,Minas Gerais','Tangará da Serra, Mato Grosso',' Leme, São Paulo',' Itaperuna, Rio de Janeiro','Breves,Pará','Nova Serrana, Minas Gerais',' Iguatu, Ceará',' São Gonçalo do Amarante, Rio Grande do Norte',' Itanhaém, São Paulo','Santo Antônio de Jesus,Bahia',' Caieiras, São Paulo',' Itacoatiara, Amazonas','Itaituba,Pará',' Aracruz, Espírito Santo',' Jataí, Goiás',' Barra do Piraí, Rio de Janeiro',' Fazenda Rio Grande, Paraná',' Mairiporã, São Paulo',' Pará de Minas, Minas Gerais');

    //BUSCA TODOS AS ASSOCIACOES CADASTRAADS PRA SABER SE INSERRE OU ATUALIZA
    $associacoes = $con->exec_query("SELECT * FROM ASSOCIACOES"); 
    $places_ids = array();
    foreach($associacoes as $assoc)
    {
        $places_ids[] = $assoc['place_id'];
    }

    //BUSCA TODOS O JSONs CADASRTADOS PARA POPULAR A TABELA DE ASSOCIACOES
    $paginas = $con->exec_query("SELECT * FROM PLACES"); 
    foreach($paginas as $pag)
    {
        $array = json_decode($pag['json']);

        //UPDATE
        if(in_array($array['place_id'], $places_ids))
        {

        }
        //INSERT
        else
        {

        }
    }

    $crowler->SetArrayIds($ids_associacoes);

    //PARA CADA CIDADE COM MAIS DE 100.000 HABITANTES
    foreach($array_top_cidades as $cidade)
    {
        $array = explode(',', $cidade);
        $cid = trim($array[0]);
        $uf = trim($array[1]);
        echo $uf.'---';
        echo $cid.'/'.$array_estados[$uf].'<br/>';

        //BUSCA AS ASSOCIAÇÕES
        $query = urlencode("proteção veicular ".utf8_encode($cid.' '.$array_estados[$uf]));
        $url ="https://maps.googleapis.com/maps/api/place/textsearch/json?query=".$query."&key=".YOUR_API_KEY."&pagetoken=".$pagetoken;
        
        //PAGINAÇÃO
        $pagetoken = $crowler->BuscaAssociacoes($url);
        while($pagetoken != "")
        {
            $pagetoken = $crowler->BuscaAssociacoes($url);
        }
        $pagetoken = "";
    }

    echo 'ACABOU O DOMINGÃO';
    exit;

    #region Buscar Cidades de todo Brasil
    //PARA CADA ESTADO
    /*$estados = $con->exec_query("SELECT * FROM ESTADO");    
    foreach($estados as $uf)
    {
        //PARA CADA CIDADE
        $cidades = $con->exec_query("SELECT * FROM MUNICIPIO WHERE UF = '".$uf['Uf']."'");     
        foreach($cidades as $cidade)
        {
            //BUSCA AS ASSOCIAÇÕES
            $query = urlencode("proteção veicular ".utf8_encode($cidade["Nome"]." ".$uf['Uf']));
            $url ="https://maps.googleapis.com/maps/api/place/textsearch/json?query=".$query."&key=".YOUR_API_KEY."&pagetoken=".$pagetoken;
            
            //PAGINAÇÃO
            $pagetoken = $crowler->BuscaAssociacoes($url);
            while($pagetoken != "")
            {
                $pagetoken = $crowler->BuscaAssociacoes($url);
            }
            $pagetoken = "";
        }
    }*/
    #endregion

    class Crawler
    {
        private $ids_associacoes;

        public function __construct()
        {
            $this->ids_associacoes = array();
        }

        public function SetArrayIds($array)
        {
            $this->ids_associacoes = $array;
        }

        //BUSCA ASSOCIAÇÕES DE UMA CIDADE
        //INSERE NO BANCO SE NÃO EXISTIR
        public function BuscaAssociacoes($url)
        {
            $conn = new Conexao();
            $pagetoken = "";

            try
            {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $response = curl_exec($ch);
                curl_close($ch);
                $response_a = json_decode($response);
                //var_dump($response_a);
                $conn->exec_query("INSERT INTO PLACES (DATA, JSON) VALUES (now(), '".$response."')");    
                $id_requisicao = $conn->retorna_id();

                $pagetoken = "";
                if(property_exists($response_a, 'next_page_token'))
                    $pagetoken = $response_a->next_page_token;

                foreach($response_a->results as $associacao)
                {
                    
                    $url ="https://maps.googleapis.com/maps/api/place/details/json?place_id=".$associacao->place_id."&key=".YOUR_API_KEY;
                    echo $url;

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $response_b = json_decode($response);
                    /*var_dump($response_b);
                    var_dump($response_b->result->website);//exit;
                    var_dump($response_b->result->place_id);//exit;*/
                    $conn->exec_query("INSERT INTO PLACE (DATA, JSON, ID_REQUISICAO) 
                    VALUES (now(), '".$response."', ".$id_requisicao.")"); 
                    //exit;
                    /*if(!in_array($associacao->place_id, $this->ids_associacoes))
                    {
                        $conn->exec_query("INSERT INTO ASSOCIACOES (SITE, PLACE_ID) VALUES ('".$response_b->result->website."', '".$response_b->result->place_id."')");    
                        $this->ids_associacoes[] = $response_b->result->place_id;
                    }*/
                }
            }
            catch(Exception $e) 
            {
                echo 'Exceção capturada: ',  $e->getMessage(), "\n";
            }
            finally
            {
                $conn->desconectar();
            }

            //sleep(3);
            return $pagetoken;
        }
    }

?>