PROGRAM GetParam(INPUT, OUTPUT);
USES DOS;

FUNCTION GetQueryStringParameter(key: STRING): STRING;
VAR
  qs, find, part: STRING;
  s, e: INTEGER;
BEGIN
  qs := GetEnv('QUERY_STRING');    { например: first_name=Ann&age=20 }
  find := key + '=';
  s := Pos(find, qs);

  IF s = 0 THEN
    GetQueryStringParameter := ''
  ELSE
  BEGIN
    s := s + Length(find);
    part := Copy(qs, s, Length(qs) - s + 1);
    e := Pos('&', part);

    IF e = 0 THEN
      GetQueryStringParameter := part
    ELSE
      GetQueryStringParameter := Copy(part, 1, e - 1);
  END;
END;

BEGIN
  WRITELN('Content-Type: text/plain');
  WRITELN;

  WRITELN('First Name: ', GetQueryStringParameter('first_name'));
  WRITELN('Last Name: ',  GetQueryStringParameter('last_name'));
  WRITELN('Age: ',        GetQueryStringParameter('age'));
END.
