SC.initialize({
                client_id: '1698f61ef0bd9cf032d6bf076e745e5f'
                });

                SC.get('/tracks', {
q: 'buskers', license: 'cc-by-sa'
}).then(function(tracks) {
                  console.log(tracks);
                  var track = tracks[0]['uri'].split('/');
                  SC.stream('/' + track[3] + '/' + track[4]).then(function(player){
                        player.play();
                  console.log(player.on('finish', document.write("finish")));
                  document.write("pass");
});
                });
