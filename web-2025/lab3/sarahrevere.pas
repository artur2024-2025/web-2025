PROGRAM SarahRevere(INPUT, OUTPUT);
USES Dos;

FUNCTION GetParam(const Key: STRING): STRING;
VAR qs, pair, k, v: STRING; amp, eq: INTEGER;
BEGIN
  qs := GetEnv('QUERY_STRING') + '&';
  GetParam := '';
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
        GetParam := v;
        EXIT;
      END;
    END;
  END;
END;

PROCEDURE SendHeader; BEGIN WRITELN('Content-Type: text/plain'); WRITELN; END;

VAR lns: STRING;
BEGIN
  SendHeader;
  lns := GetParam('lanterns');
  IF lns = '1' THEN
    WRITELN('The British are coming by land!')
  ELSE IF lns = '2' THEN
    WRITELN('The British are coming by sea!')
  ELSE
    WRITELN('Unknown signal');
END.
