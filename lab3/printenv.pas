PROGRAM PrintEnv(INPUT, OUTPUT);
USES
  DOS;
BEGIN
  WRITELN('Content-Type: text/plain');
  WRITELN;  { пустая строка }

  WRITELN('REQUEST_METHOD = ', GetEnv('REQUEST_METHOD'));
  WRITELN('QUERY_STRING   = ', GetEnv('QUERY_STRING'));   { попробуй ?name=Ivan }
  WRITELN('CONTENT_LENGTH = ', GetEnv('CONTENT_LENGTH')); { для GET будет пусто — это нормально }
  WRITELN('HTTP_USER_AGENT= ', GetEnv('HTTP_USER_AGENT'));
  WRITELN('HTTP_HOST      = ', GetEnv('HTTP_HOST'));
END.
