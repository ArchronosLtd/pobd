let progressTimer = null;

window.addEventListener('load', function() {
  setupLiveVideo();
});

function getVideoId() {
  var url = event_vars.event.event_attributes.service_video;
  if(url) {
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
    var match = url.match(regExp);
    var id = (match&&match[7].length==11)? match[7] : false;
    return id;
  }
}

function setupLiveVideo() {
  const scrobbler = document.querySelector('#track');

  function scrobblerinteract(cb) {
    if(scrobbler) {
      cb();
    }
  }

  function onPlayerReady(event) {
    scrobblerinteract(() => {
      setInterval(function() {
        if(player.getPlayerState() === YT.PlayerState.PLAYING) {
          document.querySelector('[type="range"]').value = player.getCurrentTime();
        }
      }, 1000);  
    });
    scrobblerinteract(() => {
      scrobbler.addEventListener('change', (e) => {
        player.seekTo(e.target.value, true);
      });
    });

    scrobblerinteract(() => {
      scrobbler.addEventListener('mousedown', (e) => {
        player.pauseVideo();
      });
    });

    scrobblerinteract(() => {
      scrobbler.addEventListener('mouseup', (e) => {
        player.playVideo();
      });
    });

    document.querySelector('#play').addEventListener('click', function() {
      player.playVideo();
    });

    document.querySelector('#pause').addEventListener('click', function() {
      player.pauseVideo();
    });

    document.querySelector('#fullscreen').addEventListener('click', function() {
      var iframe = document.querySelector('#player');
      var requestFullscreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen;
      if(requestFullscreen) {
        requestFullscreen.call(iframe);
      }
    });

    document.querySelector('#mute').addEventListener('click', function(e) {
      var el = e.target;

      if(player.isMuted()) {
        player.unMute();
        document.querySelector('.fa-volume-mute').classList.remove('hidden');
        document.querySelector('.fa-volume').classList.add('hidden');
      } else {
        player.mute();
        document.querySelector('.fa-volume-mute').classList.add('hidden');
        document.querySelector('.fa-volume').classList.remove('hidden');
      }
    });
  }

  function onPlayerStateChange(e) {
    if (e.data == YT.PlayerState.PLAYING) {
      document.querySelector('[type="range"]').max = player.getDuration();
      document.querySelector('#pause').classList.remove('hidden');
      document.querySelector('#pause').classList.remove('hidden');
      scrobblerinteract(() => {
        scrobbler.classList.remove('hidden');
      });
      document.querySelector('#mute').classList.remove('hidden');
      document.querySelector('#fullscreen').classList.remove('hidden');
      document.querySelector('#play').classList.add('hidden');
      document.querySelector('#player').parentElement.classList.add('playing');
      return;
    }

    if (e.data == YT.PlayerState.PAUSED) {
      document.querySelector('#pause').classList.add('hidden');
      document.querySelector('#mute').classList.add('hidden');
      document.querySelector('#play').classList.remove('hidden');
      document.querySelector('#fullscreen').classList.add('hidden');
      document.querySelector('#player').parentElement.classList.remove('playing');
      return;
    }
  }
  
  player = new YT.Player('player', {
    videoId: getVideoId(),
    playerVars: {
      playsinline: 1,
      modestbranding: 1,
      controls: 0,
      rel: 0
    },
    events: {
      'onReady': onPlayerReady,
      'onStateChange': onPlayerStateChange
    }
  });
}