<html lang="en">
<head>
	<meta charset = "UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Music Player</title>
	<script src="/assets/js/jquery.js"></script>
	<script src="/assets/js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap-theme.css">
	<style>
	.container-fluid{margin-top:20px; margin-left: 20px; }
	.songnav{width:3.8%;}
	.window{
		border: 1px solid rgb(204, 204, 204); 
		height:40px;
		background-image: linear-gradient(to bottom, #ffffff 0%, #e0e0e0 100%);
		border-radius:6px;
		margin-left: 1px;
		text-align: center;
		}
	</style>
	<script>
	var currentSong=-1
	$(document).ready(function(){
			var audio;
			var audio2;
			var startloop;
			var nextwithtimer;
			var stopsongs;
		$(document).on('click',"#next",function(){
			clearTimeout(startloop);
			clearTimeout(nextwithtimer);
			clearTimeout(stopsongs);
			audio.pause();
			audio2.pause();
			startnew(currentSong+1);});
		startnew(0);

		function startnew(i){var songs = $.get(
			"getsongs",
			function(output){
				{
				audio = new Audio(output[i]['url']);
				currentSong+=1
				var timer=parseInt(0);
				audio.playbackRate=1.0;
				audio.play();
				audio2 = new Audio(output[i+1]['loop']);
				var rate= output[i]['bpm']/output[i+1]['bpm'];
				audio2.playbackRate=rate;
				audio2.volume=0;
				audio2.play();
				$("#songname").fadeOut(1000,function(){
				$("#songname").html(output[i]['songname']).fadeIn(1000)});
				$("#artist").fadeOut(1000, function(){
				$("#artist").html(output[i]['artist']).fadeIn(1000)});
				timer=parseInt(timer) + output[i]['endsongafterbeatshort'];
				if(rate<1.15 || rate>0.85){
				startloop=setTimeout(function() { audio2.volume=1.0; audio2.play(); }, output[i]['endsongshort']);}
				nextwithtimer=setTimeout(function() {  playnext(i+1,output,5000); }, (parseInt(timer)-5000));
				stopsongs=setTimeout(function() { audio.pause();
										audio2.pause();
										$("#songname").fadeOut(1000,function(){
										$("#songname").html(output[i+1]['songname']).fadeIn(1000)});
										$("#artist").fadeOut(1000,function(){
										$("#artist").html(output[i+1]['artist']).fadeIn(1000)});
										}, parseInt(timer));
				
			};},"json");}
				

				

		

		function playnext(i,output,timer){
				currentSong+=1;
				audio = new Audio(output[i]['url']);
				audio.volume=0;
				audio.play();
				if(output[i+1]){
				audio2 = new Audio(output[i+1]['loop']);
				var rate= output[i]['bpm']/output[i+1]['bpm'];
				audio2.playbackRate=rate;
				audio2.volume=0;
				audio2.play();}
				setTimeout(function() {  
					audio.pause();
					audio.volume=1.0;
					audio.currentTime=((output[i]['startsong1']-output[i]['beginoffset'])/1000); 
					audio.play();
					if(output[i+1]){audio2.pause();
					audio2.currentTime=0};
					}, (parseInt(timer)-parseInt(output[i]['beginoffset']))
					);
				
				
				
				if(output[i+1]){
				if(rate<1.15 || rate>0.85){
				setTimeout(function() { console.log("1");
					audio2.volume=1.0; 
					audio2.play(); 
					}, parseInt(timer) - (output[i]['startsong1'])  + parseInt(output[i]['endsongshort']))};

				if(i<output.length){setTimeout(function() {playnext(i+1); }, (parseInt(output[i]['endsongafterbeatshort']-parseInt(output[i]['startsong1']))));};}

				setTimeout(function() { console.log("2");
					audio.pause(); 
					if(output[i+1]){audio2.pause()}; 
					}, parseInt(timer) - (output[i]['startsong1'])  + parseInt(output[i]['endsongafterbeatshort']));


		}})
			
				


				
</script> 
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="songnav col-md-1">
				<button type="button" class="btn btn-default btn-lg">
					<span class="glyphicon glyphicon-fast-backward" aria-hidden="true"></span>
				</button>
			</div>
		  	<div class="songnav col-md-1">
				<button type="button" class="btn btn-default btn-lg">
					<span class="glyphicon glyphicon-stop" aria-hidden="true"></span>
				</button>
			</div>
		  	<div class="songnav col-md-1">
				<button type="button" class="btn btn-default btn-lg">
					<span class="glyphicon glyphicon-play" aria-hidden="true"></span>
				</button>
			</div>
		  	<div class="songnav col-md-1">
				<button type="button" class="btn btn-default btn-lg">
					<span class="glyphicon glyphicon-pause" aria-hidden="true"></span>
				</button>
			</div>
		  	<div class="songnav col-md-1">
				<button type="button" class="btn btn-default btn-lg" id="next">
					<span class="glyphicon glyphicon-fast-forward" aria-hidden="true" ></span>
				</button>
			</div>
		  	<div class="col-md-5"><div class="window"><span id="songname"></span><br><span id="artist"></span></div></div>
		  	<div class="col-md-1 col-md-offset-7">.col-md-1</div>

		</div>
	</div>



<script>
</script>
</body>