{{-- Vendor Scripts --}}
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/ui/prism.min.js')) }}"></script>
@yield('vendor-script')
{{-- Theme Scripts --}}
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/components.js')) }}"></script>
@if($configData['blankPage'] == true)
<script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/footer.js')) }}"></script>
@endif
{{-- page script --}}
@yield('page-script')
{{-- page script --}}

{{-- core script
  FIXME: Move in webpack
 --}}
@if(Auth::check())
<script>
  $(document).ready(function() {
    var _paceIgnore = window.Pace ? window.Pace.ignore : function(f) { f(); };

    window._appVars = {
        _idleTime: 0,
        _limit: 0, // sec
        _timerID: null,
        _sessionTimerID: null,
        _sessionCheckMutex: false
    };

    let TIMER_INTERVAL = 1; // sec.
    let SESSION_CHECK_INTERVAL = 15;
    var DOM_ACTIVITIES = [
        'keydown',
        'click',
        'mousemove',
        'touchstart',
        'scroll',
        'focus'
    ]

    var _onTick = function() {
        var state = window._appVars;

        if(state._idleTime >= state._limit) {
            window.location.href = "/logout/idle";
            clearInterval(state._timerID);
            return;
        }
        ++ window._appVars._idleTime;
    }

    var _onSessionTick = function() {
        var state = window._appVars;

        // current http request not finished?
        if(state._sessionCheckMutex)
            return;

        state._sessionCheckMutex = true;

        // begin request
        _paceIgnore(() => {
          $.get({
              url: '/session-check',
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          })
          .done((res) => {
              if(!res.authorized) {
                  window.location.href = "/logout/expired";
              }
          })
          .fail((res) => {
              if(res.status == 401) {// unauthorized
                  window.location.href = "/logout/expired";
              }
          })
          .always(() => {
              window._appVars._sessionCheckMutex = false;
          })
      });
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
            }
        })

    // window._appVars._sessionTimerID =
    //     window.setInterval(_onSessionTick, SESSION_CHECK_INTERVAL * 1000);
  });
</script>
@endif
