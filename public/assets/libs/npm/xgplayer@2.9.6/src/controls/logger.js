/* eslint-disable */
import Player from '../player'
import sniffer from '../utils/sniffer'
import Collector from './collect'

let logger = function () {
  let player = this
  let util = Player.util
  if (player.config.noLog !== true) {
    if(!window.__xigua_log_sdk__) {
      window.__xigua_log_sdk__ = new Collector('tracker');
      window.__xigua_log_sdk__.init({
        app_id: 1300,
        channel: 'cn',
        log: false,
        disable_sdk_monitor: true
      })

      window.__xigua_log_sdk__('config', {
        evtParams: {
          log_type: 'logger',
          page_url: document.URL,
          domain: window.location.host,
          pver: player.version,
          ua: navigator.userAgent.toLowerCase()
        },
        disable_auto_pv: true
      })
      window.__xigua_log_sdk__.start()
    }

    if(player.config.uid) {
      window.__xigua_log_sdk__('config', {
        user_unique_id: player.config.uid
      })
    }

    let judgePtVt = function () {
      if(!player.logParams.pt || !player.logParams.vt) {
        player.logParams.pt = new Date().getTime()
        player.logParams.vt = player.logParams.pt
      }
      if(player.logParams.pt > player.logParams.vt) {
        player.logParams.pt = player.logParams.vt
      }
    }

    let userLeave = function (event) {
      if (util.hasClass(player.root, 'xgplayer-is-enter')) {
        let lt = new Date().getTime()
        let obj = {
          url: player.logParams.pluginSrc ? player.logParams.pluginSrc : player.logParams.playSrc,
          vid: player.config.vid,
          pt: player.logParams.pt,
          lt
        }
        window.__xigua_log_sdk__('b', obj)
      } else if (util.hasClass(player.root, 'xgplayer-playing')) {
        let watch_dur = util.computeWatchDur(player.logParams.played)
        let lt = new Date().getTime()
        judgePtVt()
        let obj = {
          url: player.logParams.pluginSrc ? player.logParams.pluginSrc : player.logParams.playSrc,
          vid: player.config.vid,
          bc: player.logParams.bc - 1 > 0 ? player.logParams.bc - 1 : 0,
          bb: player.logParams.bc - 1 > 0 ? 1 : 0,
          bu_acu_t: player.logParams.bu_acu_t,
          pt: player.logParams.pt,
          vt: player.logParams.vt,
          vd: player.logParams.vd * 1000,
          watch_dur: parseFloat((watch_dur * 1000).toFixed(3)),
          cur_play_pos: parseFloat((player.currentTime * 1000).toFixed(3)),
          lt
        }
        window.__xigua_log_sdk__('d', obj)
      }
    }
    if (sniffer.device === 'pc') {
      window.addEventListener('beforeunload', userLeave, false)
    } else if (sniffer.device === 'mobile') {
      window.addEventListener('pagehide', userLeave, false)
    }
    player.on('routechange', userLeave)

    function destroyFunc () {
      if (sniffer.device === 'pc') {
        window.removeEventListener('beforeunload', userLeave)
      } else if (sniffer.device === 'mobile') {
        window.removeEventListener('pagehide', userLeave)
      }
      player.off('routechange', userLeave)
      player.off('destroy', destroyFunc)
    }
    player.once('destroy', destroyFunc)
  }
}

Player.install('logger', logger)
