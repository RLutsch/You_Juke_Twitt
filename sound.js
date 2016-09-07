SC.initialize({
	client_id: '1698f61ef0bd9cf032d6bf076e745e5f'
});

var	current_song;

//window.onload = function () {
//	search_song(tweet.text);
//}

function search_song(search)
{
	console.log("Searching");
	var sound = search.split("#");
	console.log(sound[0].trim());
	SC.get('/tracks', {q: sound[0].trim()}).then(function (tracks)
		{
			var song = tracks[0];
			console.log(song);
			playtrack(song.id);
		});
}

function playtrack(id)
{
	SC.stream('/tracks/' + id).then(
	function (song)
	{
		current_song = song;
		current_song.play();
		console.log("Playing");
		current_song.on('finish', next);
	});
}

function next()
{
	console.log("Stopped");
}
