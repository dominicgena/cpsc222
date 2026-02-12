import sys
import logging

logging.basicConfig(level=logging.DEBUG, filename='/var/www/html/usrgrpsrv/logs/usrgrpsrv.log', format='%(asctime)s %(message)s')
sys.path.insert(0, '/var/www/html/usrgrpsrv')
sys.path.insert(0, '/var/www/html/usrgrpsrv/usrgrpsrv/lib/python3.12/site-packages')

from app import app as application
