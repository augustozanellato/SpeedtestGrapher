FROM python:3.8-alpine
ENV TZ="Europe/Rome"
RUN apk add tzdata
RUN mkdir /speedtest
COPY requirements.txt /speedtest
RUN pip install -r /speedtest/requirements.txt
ADD https://github.com/eficode/wait-for/raw/master/wait-for /speedtest/wait-for
RUN chmod +x /speedtest/wait-for
COPY launcher.sh /speedtest
COPY speedtest_runner.py /speedtest
ENTRYPOINT [ "/speedtest/launcher.sh" ]