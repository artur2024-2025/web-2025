PROGRAM HelloName(INPUT, OUTPUT);
USES DOS;
VAR
  QueryString: STRING;
  AmpPos: INTEGER;      { позиция & после name=... }
  Name: STRING;
BEGIN
  WRITELN('Content-Type: text/plain');
  WRITELN;  { пустая строка }

  QueryString := GetEnv('QUERY_STRING');  { например: name=Ivan&x=1 }

  { параметр name либо первый, либо отсутствует }
  IF Copy(QueryString, 1, 5) = 'name=' THEN
  BEGIN
    AmpPos := Pos('&', QueryString);
    IF AmpPos = 0 THEN
      Name := Copy(QueryString, 6, Length(QueryString) - 5)   { всё после 'name=' }
    ELSE
      Name := Copy(QueryString, 6, AmpPos - 6 + 1);           { до '&' включительно минус смещение }

    IF Name <> '' THEN
      WRITELN('Hello dear, ', Name, '!')
    ELSE
      WRITELN('Hello Anonymous!')
  END
  ELSE
    WRITELN('Hello Anonymous!');
END.
