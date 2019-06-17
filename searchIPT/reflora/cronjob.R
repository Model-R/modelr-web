################
## Start Unix ##
################

#install.packages('devtools')
library(devtools)
#install_github("bnosac/cronR")
library(cronR)
cat(file.path(getwd(), "searchIPT/reflora/extract_ipt.R"))
extract_ipt_script <- file.path(getwd(), "searchIPT/reflora/extract_ipt.R")
cmd <- cron_rscript(extract_ipt_script)

cron_clear(ask=FALSE)
cron_add(command = cmd, frequency = 'weekly',
         id = 'extract_data_from_ipts_weekly',
         description = 'Extracting data from reflora IPTs every week',
         at='2AM',
         days_of_week = c(0))

##############
## End Unix ##
##############

###################
## Start Windows ##
###################
# install.packages("taskscheduleR")
# library(taskscheduleR)
# 
# setwd("C:/Users/JBRJ/Marcos")
# extract_ipt_script <- file.path(getwd(), "extract_ipt.R")
# 
# taskscheduler_delete(taskname = "extract_data_from_ipts_weekly")
# 
# taskscheduler_create(taskname = "extract_data_from_ipts_weekly", rscript = extract_ipt_script, 
#                      schedule = "WEEKLY", starttime = "02:00", days = c('SUN'))

###################
### End Windows ###
###################

## log file is at the place where the extract_ipt.R script was located
#mylog <- file.path(getwd(), "extract_ipt.log")
#cat(readLines(mylog), sep = "\n")
