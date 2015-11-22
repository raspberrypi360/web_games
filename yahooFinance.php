<?php
	$symbol = $_REQUEST["symbol"];
	$startDate = $_REQUEST["startDate"];
	$endDate = $_REQUEST["endDate"];
	if ($symbol == null){
		$symbol = "RHT";
	}
	if ($startDate == null){
		$startDate = "2014-06-30";
	}
	if ($endDate == null){
		$endDate = "2015-01-01";
	}
	$oldData = file_get_contents("https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.historicaldata%20where%20symbol%20%3D%20%22{$symbol}%22%20and%20startDate%20%3D%20%22{$startDate}%22%20and%20endDate%20%3D%20%22{$endDate}%22&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=");
	$data = json_decode($oldData);
	if ($data->query->results == null){
		print("time span is too long");
	}
	else{
		$quote = $data->query->results->quote;
		$resultSymbol = $quote[0]->Symbol;
		$result = array();
		for ($i = 0; $i < count($quote); $i++){
			$date = $quote[$i]->Date;
			$high = $quote[$i]->High;
			$low = $quote[$i]->Low;
			$open = $quote[$i]->Open;
			$close = $quote[$i]->Close;
			$info = array("date"=>$date, "high"=>$high, "low"=>$low, "open"=>$open, "close"=>$close);
			$result[] = $info;
		}
		print(json_encode($result, JSON_PRETTY_PRINT));
	}
?>