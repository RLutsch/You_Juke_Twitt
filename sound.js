SC.initialize({
	client_id: '1698f61ef0bd9cf032d6bf076e745e5f'
});

var	current_song;

window.onload = function () {
	search_song("Hallo");
}

function search_song(search)
{
	console.log("Searching");
	SC.get('/tracks', {q: search}).then(function (tracks)
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
		if (current_song)
		{
			current_song.stop();
			document.append("stop");
		}
		current_song = song;
		current_song.play();
		console.log("Playing");
	});
}
