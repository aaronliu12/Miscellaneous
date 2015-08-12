import glob, os
import fnmatch
# Import smtplib for the actual sending function
import smtplib
import csv

# Import the email modules we'll need
from email.mime.text import MIMEText

		
fobj = open('test.csv')
lines = fobj.readlines()
if len(lines) == 1:
	lines = lines[0].split("\r")
for i in range(len(lines)):
	lines[i] = lines[i].strip().split(",")
totalarray = lines

playernames = []

matches_dictionary = {}
	

for i in range(len(totalarray)):
	for j in range(len(totalarray[0])):
		x = 1
		for x in range(len(totalarray)):
			if totalarray[x][1] == totalarray[i][j]:
				for y in range(len(totalarray[x])):
					if totalarray[x][1] == totalarray[i][1]:
						pass
					elif totalarray[x][y] == totalarray[i][1]:
						if totalarray[i][1] in matches_dictionary:
							matches_dictionary[totalarray[i][1]].append(totalarray[x][1])
						else:
							matches_dictionary[totalarray[i][1]] = [totalarray[x][1]]


print(matches_dictionary)

writer = csv.writer(open('results.csv', 'w'))
for key in matches_dictionary.items():
	key[1].append(key[0])
	print(key[1])
	writer.writerows(key[1])
fobj.close()



