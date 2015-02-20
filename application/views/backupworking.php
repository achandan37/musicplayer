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
		var timeouts=[];
		StartSong(0);
		})


function StartSong(i){$.get(
	"getsongs",
	function(output){
		{
		audio = new Audio(output[i]['url']);
		audio.play();
		audio2 = new Audio(output[i+1]['loop']);
		var rate= output[i]['bpm']/output[i+1]['bpm'];
		audio2.playbackRate=rate;
		audio2.volume=0;
		audio2.play();
		if(rate<1.15 || rate>0.85){
		setTimeout(function() { audio2.volume=1.0;audio2.play(); }, parseInt(output[i]['endsongshort']));}
		setTimeout(function() { audio.pause();
								audio2.pause();
								}, parseInt(output[i]['endsongafterbeatshort']))
		setTimeout(function() {  playnext(i+1,5000); }, (parseInt(output[i]['endsongafterbeatshort'])-5000)
	);};}
	
	,"json");}

			
function playnext(i,timer){
			$.get(
			"getsongs",
			function(output){
				{
				var audio3 = new Audio(output[i]['url']);
				audio3.volume=0;
				audio3.play();
				if(output[i+1]){
				var audio4 = new Audio(output[i+1]['loop']);
				var rate= output[i]['bpm']/output[i+1]['bpm'];
				audio4.playbackRate=rate;
				audio4.volume=0;
				console.log(parseInt(timer)- parseInt(output[i]['startsong1']) + parseInt(output[i]['endsongshort']));
				audio4.play();}
				setTimeout(function() {  
					audio3.pause();
					audio3.volume=1.0;
					audio3.currentTime=((parseInt(output[i]['startsong1'])-parseInt(output[i]['beginoffset']))/1000); 
					audio3.play();
					if(output[i+1]){audio4.pause();
					audio4.currentTime=0};
					}, (parseInt(timer)-parseInt(output[i]['beginoffset']))
					);
				
				
				
				if(output[i+1]){
				if(rate<1.15 || rate>0.85){
				setTimeout(function() { console.log("1");
					audio4.volume=1.0; 
					audio4.play(); 
					}, parseInt(timer) - parseInt(output[i]['startsong1']) + parseInt(output[i]['endsongshort']))};

				if(i<output.length){setTimeout(function() {playnext(i+1,5000); }, (parseInt(output[i]['endsongafterbeatshort']-parseInt(output[i]['startsong1'])-5000+parseInt(timer))));};}

				setTimeout(function() { console.log("2");
					audio3.pause(); 
					if(output[i+1]){audio4.pause()}; 
					}, parseInt(timer) - parseInt(output[i]['startsong1'])  + parseInt(output[i]['endsongafterbeatshort']));


		}},"json");}
			






				
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