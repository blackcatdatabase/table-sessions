-- Auto-generated from core/joins-postgres.yaml (map@sha1:29CF395A3A4C8964482083733F8E613ABFBEF5CC)
-- engine: postgres
-- view:   sessions_active_by_user

-- Active sessions per user
CREATE OR REPLACE VIEW vw_sessions_active_by_user AS
SELECT
  user_id,
  COUNT(*) AS active_sessions,
  MIN(created_at) AS first_created_at,
  MAX(last_seen_at) AS last_seen_at
FROM sessions
WHERE revoked = false AND (expires_at IS NULL OR expires_at > now())
GROUP BY user_id
ORDER BY active_sessions DESC;
