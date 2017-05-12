import socket
import struct   
from random import randrange
from urllib import urlopen
import re
import optparse

#sample tracker http://anidex.moe:6969/announce

parser = optparse.OptionParser()
parser.add_option('-t', '--tracker', help='Tracker')
parser.add_option('-p', '--port', type="int", help='Port')
parser.add_option('-l', '--torrenthash', help='Torrent hash')
(options, args) = parser.parse_args()
tracker = options.tracker
port = options.port
torrent_hash = [options.torrenthash]
print options
print torrent_hash
torrent_details = {}

def show(infohash):
    print "Torrent Hash: ", infohash
    print "Seeds, Leechers, Completed", torrent_details[infohash] 

#Create the socket
clientSocket = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
clientSocket.connect((tracker, port))

#Protocol ID do not touch
connection_id=0x41727101980
#Transaction ID is always random
transaction_id = randrange(1,65535)

packet = struct.pack(">QLL",connection_id, 0,transaction_id)
clientSocket.send(packet)
res = clientSocket.recv(16)
action,transaction_id,connection_id = struct.unpack(">LLQ",res)

hashes = ""
for infohash in torrent_hash:
    hashes = hashes + infohash.decode('hex')

packet = struct.pack(">QLL", connection_id, 2, transaction_id) + hashes

clientSocket.send(packet)
res = clientSocket.recv(8 + 12*len(torrent_hash))

index = 8
for infohash in torrent_hash:
    seeders, completed, leechers = struct.unpack(">LLL", res[index:index+12])
    torrent_details[infohash] = (seeders, leechers, completed)
    show(infohash)
    index = index + 12
