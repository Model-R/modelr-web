#install.packages('stringr')
#install.packages('finch')
#install.packages('dplyr')
library(stringr)
library(finch)
library(dplyr)

if(getwd() != "/var/www/html/rafael/modelr"){
	cat('v2')
	baseUrl <- '../'
} else {
	cat('main')
	baseUrl <- ''
}

destination_folder_path = "/var/www/html/rafael/modelr-data/ipt/reflora/"

extracted_urls = c(
    "http://ipt.jbrj.gov.br/reflora/resource?r=alcb_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=ase_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=brba",
    "http://ipt.jbrj.gov.br/reflora/resource?r=cepec_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=cesj",
    "http://ipt.jbrj.gov.br/reflora/resource?r=cor",
    "http://ipt.jbrj.gov.br/reflora/resource?r=cri",
    "http://ipt.jbrj.gov.br/reflora/resource?r=dvpr",
    "http://ipt.jbrj.gov.br/reflora/resource?r=e_hv",
    "http://ipt.jbrj.gov.br/reflora/resource?r=eac_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=ect",
    "http://ipt.jbrj.gov.br/reflora/resource?r=esa_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=flor_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=furb_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=hbr_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=hdcf_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=heph",
    "http://ipt.jbrj.gov.br/reflora/resource?r=hrcb",
    "http://ipt.jbrj.gov.br/reflora/resource?r=hucp",
    "http://ipt.jbrj.gov.br/reflora/resource?r=hufu_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=ian",
    "http://ipt.jbrj.gov.br/reflora/resource?r=joi",
    "http://ipt.jbrj.gov.br/reflora/resource?r=k_reflora",
    "http://ipt.jbrj.gov.br/reflora/resource?r=lusc",
    "http://ipt.jbrj.gov.br/reflora/resource?r=mac",
    "http://ipt.jbrj.gov.br/reflora/resource?r=mbm_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=mbml",
    "http://ipt.jbrj.gov.br/reflora/resource?r=moh",
    "http://ipt.jbrj.gov.br/reflora/resource?r=nyh",
    "http://ipt.jbrj.gov.br/reflora/resource?r=p_reflora",
  # "http://ipt.jbrj.gov.br/reflora/resource?r=reflora",
    "http://ipt.jbrj.gov.br/reflora/resource?r=s_reflora",
    "http://ipt.jbrj.gov.br/reflora/resource?r=sof",
    "http://ipt.jbrj.gov.br/reflora/resource?r=spf_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=ubh",
    "http://ipt.jbrj.gov.br/reflora/resource?r=ufrn_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=unip",
    "http://ipt.jbrj.gov.br/reflora/resource?r=unop",
    "http://ipt.jbrj.gov.br/reflora/resource?r=us_reflora",
    "http://ipt.jbrj.gov.br/reflora/resource?r=vies_herbarium",
    "http://ipt.jbrj.gov.br/reflora/resource?r=w_reflora"
)

extracted_urls = str_replace(extracted_urls, "resource", "archive.do");

columns = c("id",
            "type",
            "collectionCode",
            "basisOfRecord",
            "occurrenceID",
            "catalogNumber",
            "recordNumber",
            "recordedBy",
            "associatedMedia",
            "year",
            "month",
            "day",
            "country",
            "stateProvince",
            "municipality",
            "locality",
            "decimalLatitude",
            "decimalLongitude",
            "identifiedBy",
            "dateIdentified",
            "typeStatus",
            "scientificName",
            "genus",
            "family",
            "specificEpithet",
            "infraspecificEpithet",
            "taxonRank",
            "scientificNameAuthorship"
)

ocurrences_list = list();
i = 1;
for(url in extracted_urls){
  out <- dwca_read(url, read = TRUE, encoding = 'UTF-8')
  
  hm <- out$data
  data <- select(hm$occurrence.txt, one_of(columns))
  ocurrences_list[[i]] = filter(data, !is.na(decimalLatitude) & !is.na(decimalLongitude))
  i = i + 1
}

head(ocurrences_list[[1]])
filename = paste0(destination_folder_path, "ocurrences_list.Rds")
saveRDS(ocurrences_list, file = filename)



