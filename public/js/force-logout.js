$(document).ready(function() {
    window._appVars = {
        _idleTime: 0,
        _limit: 0, // sec
        _timerID: null,
        _sessionTimerID: null,
        _sessionCheckMutex: false
    };

    let TIMER_INTERVAL = 1; // sec.
    let SESSION_CHECK_INTERVAL = 5;
    var DOM_ACTIVITIES = [
        'keydown',
        // 'keyup',
        'click',
        'mousemove',
        // 'mousewheel',
        // 'mousedown',
        'touchstart',
        // 'touchmove',
        'scroll',
        'focus'
    ]

    var _onTick = function() {
        var state = window._appVars;

        if(state._idleTime >= state._limit) {
            window.location.href = "/logout/idle";

            clearInterval(state._timerID);
            console.log('[reach idle limit]');
            return;
            //})
        }
        // console.log('tick');
        ++ window._appVars._idleTime;
    }

    var _onSessionTick = function() {
        var state = window._appVars;

        // current http request not finished?
        if(state._sessionCheckMutex)
            return;

        state._sessionCheckMutex = true;

        // begin request
        $.get({
            url: '/session-check',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done((res) => {
            if(!res.authorized) {
                // redirect
                console.log('[YOUR SESSION HAS EXPIRED.]');
                window.location.href = "/logout/expired";
            }
        })
        .fail((res) => {
            if(res.status == 401) {// unauthorized
                console.log('[YOUR SESSION HAS EXPIRED.]');
                window.location.href = "/logout/expired";
            }
        })
        .always(() => {
            window._appVars._sessionCheckMutex = false;
        })
    };

    // Startup:
    $.get('/json/js-vars')
        .done((res) => {
            var limit = parseInt(res.idle_timeout)

            // only enable timer if  limit > 10
            if(limit > 10) {
                $(document).on(DOM_ACTIVITIES.join(' '), (_) => {
                    window._appVars._idleTime = 0; // reset idle times
                });

                window._appVars._limit = limit;
                window._appVars._timerID =
                    window.setInterval(_onTick, TIMER_INTERVAL * 1000);
            } else {
                console.log('[idle timout too short: ' + limit + ']');
            }
        })

    window._appVars._sessionTimerID =
        window.setInterval(_onSessionTick, SESSION_CHECK_INTERVAL * 1000);
});
