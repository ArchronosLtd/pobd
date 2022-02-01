<?php

add_filter('em_events_build_sql_conditions', 'saintmarks_sermon_scopes', 1, 2);
function saintmarks_sermon_scopes($conditions, $args)
{
  if (!empty($args['scope']) && $args['scope'] == 'live') {
    $conditions['scope'] = ' event_start_date = CURDATE() AND SUBTIME(event_start_time, "0:30:00") < CURRENT_TIME() AND event_end_time > CURRENT_TIME()';
  }
  return $conditions;
}
