<!DOCTYPE html>
<html>
<body>

<!-- list the form data from previous page -->
Your query was: <?php echo $_POST["query"]; ?> <br>
Your rank1# was: <?php echo $_POST["refine1"]; ?><br>
Your rank2# was: <?php echo $_POST["refine2"]; ?><br>
Your rank3# was: <?php echo $_POST["refine3"]; ?><br>
Your rank4# was: <?php echo $_POST["refine4"]; ?><br>
Your rank5# was: <?php echo $_POST["refine5"]; ?><br>
<div id="id01"></div>

<script>
var i;
var xmlhttp = new XMLHttpRequest();
var xmlhttp2 = new XMLHttpRequest();
var query_append = <?php echo json_encode($_POST["query"]); ?>;
var refine1_num = <?php echo json_encode($_POST["refine1"]); ?>;
var refine2_num = <?php echo json_encode($_POST["refine2"]); ?>;
var refine3_num = <?php echo json_encode($_POST["refine3"]); ?>;
var refine4_num = <?php echo json_encode($_POST["refine5"]); ?>;
var refine5_num = <?php echo json_encode($_POST["refine5"]); ?>;

var dict ="";
var inp_d = ", , , , , , , , , , , , , , , , , , , ,";
var d = inp_d.split(" ");	
var rerank = "";
for (i = 0; i < d.length; i++) {
	d[i] = d[i].match(/[a-zA-Z01-9]*/i);
}

function Create2DArray(rows) {
  var arr = [];

  for (var i=0;i<rows;i++) {
     arr[i] = [];
  }

  return arr;
}
<!--  store search results (link, title and snippet) in "results" 1 to 10 -->
var results = Create2DArray(20);
var url_wo_query = "https://www.googleapis.com/customsearch/v1?key=AIzaSyD7uT8lb4yLl5w0mEpuH9uUarudMhaP4WI&cx=001605537887377932511:i9o-k8ixkqc&rsz=10&num=10&prettyPrint=true&hl=en&sort=&googlehost=www.google.com&q=";
var url = url_wo_query.concat(query_append);
<!--var url = "url1_.txt";
xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		
        var myArr = JSON.parse(xmlhttp.responseText);
            for (i = 0; i < myArr.items.length; i++) {
				
				 results[i][0] = myArr.items[i].link;
				 results[i][1] = myArr.items[i].title;
				 results[i][2] = myArr.items[i].snippet;
                 d[i] += myArr.items[i].title ;
                 d[i] += myArr.items[i].snippet ;
				 dict += d[i];
				 
				 if(((i+1) == refine1_num) || ((i+1) == refine2_num) || ((i+1) == refine3_num) ||((i+1) == refine4_num) ||((i+1) == refine5_num)){
					 rerank += myArr.items[i].title ;
					 rerank += myArr.items[i].snippet ;
					 
				 }
			}
    }
}

xmlhttp.open("GET", url, true);
xmlhttp.send();

<!--  store search results (link, title and snippet) in "results" 11 to 20 -->
var url2_wo_query = "https://www.googleapis.com/customsearch/v1?key=AIzaSyD7uT8lb4yLl5w0mEpuH9uUarudMhaP4WI&cx=001605537887377932511:i9o-k8ixkqc&rsz=10&num=10&prettyPrint=true&hl=en&sort=&googlehost=www.google.com&start=11&q=";
var url2 = url2_wo_query.concat(query_append);
<!--var url2 = "url2_.txt";
xmlhttp2.onreadystatechange = function() {
    if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
		
        var myArr = JSON.parse(xmlhttp2.responseText);
        
                for (i = 0; i < myArr.items.length; i++) {
          
				 results[i+10][0] = myArr.items[i].link;
				 results[i+10][1] = myArr.items[i].title;
				 results[i+10][2] = myArr.items[i].snippet;
                 d[i+10] += myArr.items[i].title ;
                 d[i+10] += myArr.items[i].snippet ;
				 dict += d[i+10];
				 
				 if(((i+11) == refine1_num) || ((i+11) == refine2_num) || ((i+11) == refine3_num) ||((i+11) == refine4_num) ||((i+11) == refine5_num)){
					 rerank += myArr.items[i].title ;
					 rerank += myArr.items[i].snippet ;
					 
				 }
}
				
<!-- function to process text in document-->
function processText(input_text){
<!-- ignoring case -->
var text = input_text.toLowerCase();
var splitted = text.split(" ");

var out_text= "";
var list_common = "a about above after again against all am an and any are aren't as at be because been before being below between both but by can't cannot could couldn't did didn't do does doesn't doing don't down during each few for from further had hadn't has hasn't have haven't having he he'd he'll he's her here here's hers herself him himself his how how's i i'd i'll i'm i've if in into is isn't it it's its itself let's me more most mustn't my myself no nor not of off on once only or other ought our ours	ourselves out over own same shan't she she'd she'll she's should shouldn't so some such than that that's the their theirs them themselves then there there's these they they'd they'll they're they've this those through to too under until up very was wasn't we we'd we'll we're we've were weren't what what's when when's where where's which while who who's whom why why's with won't would wouldn't you you'd you'll you're you've your yours yourself yourselves ";
var list_common = list_common.concat(query_append);
var common_split = list_common.split(" ");
                for (i = 0; i < splitted.length; i++) {
					<!-- looking for only words in text -->
					splitted[i] = splitted[i].match(/[a-zA-Z]*/i);
					
					<!-- remove common words from text -->
					for (j = 0; j< common_split.length ; j++){
						if ( common_split[j] == splitted[i]){
							splitted[i] = "";
						}
					}
					<!-- remove empty/blank string from text -->
					if(splitted[i] != ""){
						out_text +=    splitted[i] + " ";
					}
				} 
				out_text = out_text.trim();
				return out_text.split(" ");
				
				
}
<!-- for dictionary -->
function removeDuplicates(array){
	var out_text = "";
	for (i = 0; i < array.length; i++) {
		for (j = i+1; j < array.length; j++) {
			if(array[i] == array[j]){
				array[j] = "";
			}
		}
		if(array[i] != ""){
			out_text += array[i] + " ";
		}
	}
	out_text = out_text.trim();
	return out_text.split(" ");
	
}

	var dict_mod = processText(dict);
	var doc = [[], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], []];
	
	<!-- building document array ; for some reason the for loop did not work. so listed them all -->
	<!-- doc[0] to doc[19] are the 20 results -->
	<!-- doc[20] is the document from reranking selection -->
	doc[0] = processText(d[0]);
	doc[1] = processText(d[1]);
	doc[2] = processText(d[2]);
	doc[3] = processText(d[3]);
	doc[4] = processText(d[4]);
	doc[5] = processText(d[5]);
	doc[6] = processText(d[6]);
	doc[7] = processText(d[7]);
	doc[8] = processText(d[8]);
	doc[9] = processText(d[9]);
	doc[10] = processText(d[10]);
	doc[11] = processText(d[11]);
	doc[12] = processText(d[12]);
	doc[13] = processText(d[13]);
	doc[14] = processText(d[14]);
	doc[15] = processText(d[15]);
	doc[16] = processText(d[16]);
	doc[17] = processText(d[17]);
	doc[18] = processText(d[18]);
	doc[19] = processText(d[19]);
	doc[20] = processText(rerank);
	
	<!-- dict_mod - dictionary of unique words -->
	var dict_mod = removeDuplicates(dict_mod);
	var tf = Create2DArray(21);
	var idf = Create2DArray(1);
	var df = Create2DArray(1);
	var count = 0;
	var count_df = 0;
	var skip_loop = 0;
	
	
	<!-- populate term frequency array -->
	for ( var i = 0; i< tf.length; i++){
		for( var j = 0; j< dict_mod.length; j++){
			for(var k = 0 ; k < doc[i].length; k++){
					if (dict_mod[j] == doc[i][k]){
						count ++;
					}				
			}
			tf[i][j] = count;
			count = 0 ;	
		}	
	}
	
	<!-- normalize tf array -->
	var tf_norm = Create2DArray(21);
	var sum_squares = 0;
	for ( var i = 0; i< tf.length; i++){
		for( var j = 0; j< dict_mod.length; j++){
			sum_squares = sum_squares + tf[i][j]*tf[i][j];
		}
		
		for( var k = 0; k< dict_mod.length; k++){
			tf_norm[i][k] = (tf[i][k])/Math.sqrt(sum_squares);
		}
		sum_squares = 0;
	}

	<!-- calculate idf -->
	for( var j = 0; j< dict_mod.length; j++){
		for ( var i = 0; i< tf.length; i++){
			for(var k = 0 ; k < doc[i].length; k++){
					if ((dict_mod[j] == doc[i][k]) && (skip_loop == 0)){
						count_df ++;
						skip_loop = 1;
					}
						
			}
			skip_loop = 0;
		}
		df[j] = count_df;
		idf[j] = Math.log(dict_mod.length/count_df)
		count_df = 0;
	}
	
	
	<!-- calculate tf*idf -->
	var tfidf = Create2DArray(21);
	for ( var i = 0; i< tf.length; i++){
		for( var j = 0; j< dict_mod.length; j++){		
			tfidf[i][j] = tf_norm[i][j]* idf[j];
		}
	}
	
	
	<!-- normalize tf*idf -->
	var tfidf_norm = Create2DArray(21);
	sum_squares = 0;
	for ( var i = 0; i< tf.length; i++){
		for( var j = 0; j< dict_mod.length; j++){
			sum_squares = sum_squares + tfidf[i][j]*tfidf[i][j];
		}
		for( var k = 0; k< dict_mod.length; k++){
			tfidf_norm[i][k] = (tfidf[i][k])/Math.sqrt(sum_squares);
		}
		sum_squares = 0;
	}
	
	<!-- calculate cosine similarity between d[20] and others -->
	var cosine_sim = Create2DArray(20);
	var dotProd = 0;
	var sumSqr1 = 0;
	var sumSqr2 = 0;
	for(i=0; i< 20 ; i++){
		for(j=0; j< dict_mod.length ; j++){
			dotProd = dotProd+tfidf_norm[i][j]*tfidf_norm[20][j];
			sumSqr1 = sumSqr1 + tfidf_norm[i][j]*tfidf_norm[i][j];
			sumSqr2 = sumSqr2 + tfidf_norm[20][j]*tfidf_norm[20][j];
		}
		cosine_sim[i][0] = dotProd/(Math.sqrt(sumSqr1)*Math.sqrt(sumSqr2));
		cosine_sim[i][1] = i+1;
	}
	
	<!-- sort cosine_similarity -->
	for(i=0; i< 20 ; i++){
		for(j=i+1; j< 20 ; j++){
			if(cosine_sim[i][0] < cosine_sim[j][0]){
				var temp = cosine_sim[j][0];
				cosine_sim[j][0] = cosine_sim[i][0];
				cosine_sim[i][0] = temp;
				temp = cosine_sim[j][1];
				cosine_sim[j][1] = cosine_sim[i][1];
				cosine_sim[i][1] = temp;
			}
		}
	}
	<!--document.getElementById("id01").innerHTML = cosine_sim;
	<!-- rerank search results based on cosine similarity -->
	var final_text = "";
	for(i=0; i< 20 ; i++){
		j = cosine_sim[i][1]-1;
		final_text += '<a href="' + results[j][0] + '">' + cosine_sim[i][1] + " -       " + results[j][1] +  '</a><br>';
		final_text += results[j][2] +  '</a><br><br>';
	}
	document.getElementById("id01").innerHTML = final_text;
    }
}

xmlhttp2.open("GET", url2, true);
xmlhttp2.send();
</script>

</body>
</html>
