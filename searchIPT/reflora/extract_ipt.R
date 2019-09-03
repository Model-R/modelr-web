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
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=alcb_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=ase_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=b_herb",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=brba",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=cepec_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=cesj",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=cgms",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=cor",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=cri",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=dvpr",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=e_hv",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=eac_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=ebc",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=ect",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=esa_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=evb",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=flor_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=furb_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=gh_herb",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=hbr_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=hcf",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=hdcf_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=heph",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=hj_herb",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=hrcb",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=hstm",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=hucp",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=huem",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=huemg",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=hufu_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=hvasf",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=ian",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=joi",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=k_reflora",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=lusc",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=mac",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=mbm_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=mbml",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=moh",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=mufal",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=nyh",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=p_reflora",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=pc_herb",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=pmsp",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=rbr",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=real",
  # "http://ipt.jbrj.gov.br/reflora/archive.do?r=reflora",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=s_reflora",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=sames",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=sof",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=spf_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=ubh",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=ufrn_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=unip",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=unop",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=us_reflora",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=vies_herbarium",
  "http://ipt.jbrj.gov.br/reflora/archive.do?r=w_reflora",
  "http://ipt.jbrj.gov.br/jbrj/archive.do?r=jbrj_rb&v=84.190"
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
  data$recordNumber <- as.character(data$recordNumber) 
  ocurrences_list[[i]] = data
  i = i + 1
}

head(ocurrences_list[[1]])
filename = paste0(destination_folder_path, "ocurrences_list.Rds")
saveRDS(ocurrences_list, file = filename)



