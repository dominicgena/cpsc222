import sys
import logging

logging.basicConfig(level=logging.DEBUG, filename='/var/www/cpsc222/logs/usrgrpsrv.log')

sys.path.insert(0, '/var/www/cpsc222')
from app import app as application