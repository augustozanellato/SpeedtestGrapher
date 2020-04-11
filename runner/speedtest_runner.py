import schedule
import sys
import logging
import time
import os
import mysql.connector
from mysql.connector import Error as MySQLError
from speedtest import Speedtest
from threading import Thread
from dotenv import load_dotenv

load_dotenv()
logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(name)s - %(levelname)s - %(message)s')
logger = logging.getLogger("SpeedtestRunner")

def getdb():
    return mysql.connector.connect(host="db", user=os.getenv("MYSQL_USER"), passwd=os.getenv("MYSQL_PASSWORD"), database=os.getenv("MYSQL_DATABASE"))

try:
    db = getdb()
    db.cursor().execute("""
    CREATE TABLE IF NOT EXISTS `TESTS` (
        `Date` datetime NOT NULL DEFAULT current_timestamp() PRIMARY KEY,
        `Download` decimal(8,2) NOT NULL,
        `Upload` decimal(8,2) NOT NULL,
        `Ping` decimal(8,2) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;""")
    db.commit()
    db.close()
except MySQLError as e:
    logger.critical("Database connection failed: %s", e.msg)
    sys.exit(1)

def do_speedtest():
    logger.info("Starting test")
    db = getdb()
    speedtest = Speedtest()
    speedtest.get_best_server()
    speedtest.download()
    speedtest.upload()
    cursor = db.cursor()
    download = round(speedtest.results.download / 1024 / 1024, 2)
    upload = round(speedtest.results.upload / 1024 / 1024, 2)
    latency = round(speedtest.results.server["latency"], 2)
    cursor.execute("INSERT INTO TESTS (Download, Upload, Ping) VALUES (%s, %s, %s)", (download, upload, latency))
    logger.info("Speedtest results: Download %s Mbps, Upload %s Mbps, Latency: %s ms", download, upload, latency)
    db.commit()
    db.close()

def threaded_speedtest():
    Thread(target=do_speedtest).start()

threaded_speedtest()
schedule.every(int(os.getenv("TEST_INTERVAL_MINUTES"))).minutes.do(threaded_speedtest)

while True:
    schedule.run_pending()
    time.sleep(1)

