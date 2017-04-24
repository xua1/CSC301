SELECT *
FROM owner
WHERE
	username = :username AND
	password = :password
	