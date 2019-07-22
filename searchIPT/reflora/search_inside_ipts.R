library(stringr)
library(dplyr)

args <- commandArgs(TRUE)
experiment_id <- args[1]
sp <- args[2]


if(getwd() != "/var/www/html/rafael/modelr"){
	cat('v2')
	baseUrl <- '../'
} else {
	cat('main')
	baseUrl <- ''
}

source_folder = paste0(baseUrl, "../modelr-data/ipt/reflora/")
folder_path = paste0(baseUrl, "../modelr-data/ipt/reflora/searches/")

read_ocurrence_list <- readRDS(paste0(source_folder, "ocurrences_list.Rds"))
filtered_ocurrences_list = list();
i = 1;
total = 0;
for(list in read_ocurrence_list){
  list$recordNumber <- as.character(list$recordNumber) 
  filtered_ocurrences_list[[i]] = subset(list, str_detect(scientificName, regex(sp, ignore_case = T)))
  total = total + nrow(filtered_ocurrences_list[[i]])
  i = i + 1
}

total
compiled_ocurrence_list = bind_rows(filtered_ocurrences_list)
write.csv(compiled_ocurrence_list, 
            file = paste0(folder_path, sp, "_ocurrence_list-exp", experiment_id, ".csv"), 
            sep=",",
            row.names=FALSE,
            fileEncoding = "UTF-8")
