PROGRAM WorkWithQueryString(INPUT, OUTPUT);
USES Dos;

FUNCTION GetQueryStringParameter(Key: STRING): STRING;
VAR qs, pair, k, v: STRING; amp, eq: INTEGER;
BEGIN
  qs := GetEnv('QUERY_STRING') + '&';
  GetQueryStringParameter := '';
  WHILE qs <> '' DO
  BEGIN
    amp  := Pos('&', qs);
    pair := Copy(qs, 1, amp-1);
    Delete(qs, 1, amp);
    IF pair = '' THEN BREAK;
    eq := Pos('=', pair);
    IF eq > 0 THEN
    BEGIN
      k := Copy(pair, 1, eq-1);
      v := Copy(pair, eq+1, Length(pair)-eq);
      IF k = Key THEN
      BEGIN
        GetQueryStringParameter := v;
        EXIT;
      END;
    END;
  END;
END;

PROCEDURE SendHeader; BEGIN WRITELN('Content-Type: text/plain'); WRITELN; END;

BEGIN
  SendHeader;
  WRITELN('First Name: ', GetQueryStringParameter('first_name'));
  WRITELN('Last  Name: ', GetQueryStringParameter('last_name'));
  WRITELN('Age:        ', GetQueryStringParameter('age'));
END.
