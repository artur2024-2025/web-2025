PROGRAM HelloName(INPUT, OUTPUT);
USES Dos;

PROCEDURE SendHeader; BEGIN WRITELN('Content-Type: text/plain'); WRITELN; END;

VAR qs, name: STRING; posName, eq, amp: INTEGER;
BEGIN
  SendHeader;
  qs := GetEnv('QUERY_STRING');           {например: 'name=Ivan&age=19'}
  name := '';

  posName := Pos('name', qs);             {по условию: параметр либо первый, либо отсутствует}
  IF (posName = 1) THEN
  BEGIN
    eq := Pos('=', qs);
    IF eq > 0 THEN
    BEGIN
      name := Copy(qs, eq+1, Length(qs)-eq);
      amp := Pos('&', name);
      IF amp > 0 THEN
        name := Copy(name, 1, amp-1);
    END;
  END;

  IF name = '' THEN
    WRITELN('Hello Anonymous!')
  ELSE
    WRITELN('Hello dear, ', name, '!');
END.
