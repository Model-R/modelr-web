#############################
####    Script modelR   ####
############################

# Carregando pacotes
require(modleR)
require(raster)
#require(vegan)
#require(psych)
require(stringr)
require(gtools)

args <- commandArgs(TRUE)
id <- args[1]
hashId <- args[2]
repetitions <- args[3]
partitions <- args[4]
partitiontype <- args[5]
trainpercent <- args[6]
bufferValue <- args[7]
num_points <- args[8]
tss <- args[9]
threshold_bin <- args[10] 
rasterCSVPath <- args[11]
ocorrenciasCSVPath <- args[12]
algorithms <- args[13]
extensionPath <- args[14]
projectionPath <- args[15]
models <- args[16]

cat('models')
models
modelsArray <- strsplit(models, ";")
cat('\n')
modelsArray[[1]]
cat('\nantes')

if(bufferValue == 'NULL') bufferValue = NULL;
algorithms
#extensionPath <- paste0('../../../../../../','mnt/dados/modelr/json/polygon-317.json')

if(getwd() != "/var/www/html/rafael/modelr"){
	cat('v2')
	baseUrl <- '../'
} else {
	cat('main')
	baseUrl <- ''
}

coordenadas <- read.table(ocorrenciasCSVPath, sep = ';', header = T);
coordenadas
rasters <- read.table(rasterCSVPath, sep = ';', header = F, as.is = T);
rasters
#rasters <- read.file(rasterCSVPath, sep = ';', h = F)
#setwd('../../../../../')
#getwd()algorithmsArray[[1]] == TRUE
algorithmsArray <- as.list(strsplit(algorithms, ';')[[1]])
rasters <- paste0(baseUrl,'../../../../../',rasters)
stack_rasters <- stack(rasters)

proj_data_json = geojsonio::geojson_read(projectionPath, what = "sp")
data_json = geojsonio::geojson_read(extensionPath, what = "sp")
stack_rasters <- mask(crop(stack_rasters, data_json), data_json)

cat('extension')
data_json
cat('projection')
proj_data_json

especies <- unique(coordenadas$taxon);
especies
##-----------------------------------------------##
# vamos receber várias variáveis: ocorrencias.csv, raster.csv, partitions, buffer, num_points, tss, hash id
# criar variaveis_preditoras a partir de raster.csv
##-----------------------------------------------##

resultFolder <- paste0(baseUrl,'temp/result/')
#Cria diretório onde serão salvos os resultados
#dir.create(paste0(resultFolder, hashId));
clean <- function(coord, abio) {
    if (dim(coord)[2] == 2) {
        if (exists("abio")) {
            # selecionar os pontos únicos e sem NA
            mask <- abio[[1]]
            # Selecionar pontos espacialmente únicos #
            cell <- cellFromXY(mask, coord)  # get the cell number for each point
            dup <- duplicated(cell)
            pts1 <- coord[!dup, ]  # select the records that are not duplicated
            pts1 <- pts1[!is.na(extract(mask, pts1)), ]  #selecionando apenas pontos que tem valor de raster

            cat(dim(coord)[1] - dim(pts1)[1], "points removed\n")
            cat(dim(pts1)[1], "spatially unique points\n")
            names(pts1) <- c("lon", "lat")#
            return(pts1)
        } else (cat("Indicate the object with the predictive variables"))
    } else (stop("Coordinate table has more than two columns.\nThis table should only have longitude and latitude in this order."))
}
reg.clean <- c()
for (especie in especies) {
    sp.clean <- clean(coordenadas[coordenadas[, "taxon"] == especie, c("lon","lat")], stack_rasters[[1]])
    sp.clean$sp <- especie
    reg.clean <- rbind(reg.clean,sp.clean)
}
#----#
coordenadas <- reg.clean
especies <- unique(coordenadas$sp)
#----#
#foreach(especie = especies,
#        .packages = c("raster", "modelr")) %dopar% {
# algorithmsArray = Mahalanobis;Maxent;GLM;Bioclim;Random Forest;Domain;SVM
coordenadas[coordenadas$sp == especie, c("lon", "lat")]
cat('coordenadas')
coordenadas
#variaveis_cortadas <- mask(crop(stack_rasters, mascara), mascara)

for (especie in especies) {
    # especies
    ocorrencias <- coordenadas[coordenadas$sp == especie, c("lon", "lat")]
	sdmdata_1sp <- setup_sdmdata(species_name = especie,
        occurrences = ocorrencias,
        predictors = stack_rasters,
        models_dir = paste0(resultFolder, hashId),
        partition_type = partitiontype,
        cv_partitions = as.numeric(partitions),
        cv_n = as.numeric(repetitions),
        boot_proportion = as.numeric(trainpercent)/100,
	    boot_n = as.numeric(repetitions),
        seed = 512,
        buffer_type = bufferValue,
        plot_sdmdata = T,
        clean_dupl = T,
        clean_uni = T,
        clean_nas = T,
        n_back = as.numeric(num_points)
    )
	
    do_many(species_name = especie,
        sdmdata = sdmdata_1sp,
        occurrences = ocorrencias,
        predictors = stack_rasters,
        plot_sdmdata = T,
        models_dir = paste0(resultFolder, hashId),
        write_png = T,
        write_bin_cut = F,
        bioclim = algorithmsArray[[4]] == TRUE,
        maxent = algorithmsArray[[2]] == TRUE,
        glm = algorithmsArray[[3]] == TRUE,
        rf = algorithmsArray[[5]] == TRUE,
        svm.k = algorithmsArray[[7]] == TRUE,#svm agora é svm.k do pacote kernlab
        svm.e = F,#svm2 agora é svm.e do pacote e1071
        domain = algorithmsArray[[6]] == TRUE,
        mahal = algorithmsArray[[1]] == TRUE,
    )

	algorithsNames <- c();
	if(algorithmsArray[[1]] == TRUE){
		algorithsNames = c(algorithsNames,'mahal')
	}
	if(algorithmsArray[[2]] == TRUE){
		algorithsNames = c(algorithsNames, 'maxent')
	}
	if(algorithmsArray[[3]] == TRUE){
		algorithsNames = c(algorithsNames, 'glm')
	}
	if(algorithmsArray[[4]] == TRUE){
		algorithsNames = c(algorithsNames, 'bioclim')
	}
	if(algorithmsArray[[5]] == TRUE){
		algorithsNames = c(algorithsNames, 'rf')
	}
	if(algorithmsArray[[6]] == TRUE){
		algorithsNames = c(algorithsNames, 'domain')
	}
	if(algorithmsArray[[7]] == TRUE){
		algorithsNames = c(algorithsNames, 'svm')
	}
	
	#gerando os ensembles por algoritmo
    final_model(species_name = especie,
            algorithms = NULL, #if null it will take all the in-disk algorithms 
            models_dir = paste0(resultFolder, hashId),
            select_par = "TSS",
            select_par_val = tss,
            #which_models = c("bin_consensus", "raw_mean_cut"),
            which_models = modelsArray[[1]],
            consensus_level = as.numeric(threshold_bin),
            overwrite = T,
            write_png = T)

	#
	#
	#gerando o modelo final
    ensemble_model(species_name = especie,
	               occurrences = coordenadas,
                   models_dir = paste0(resultFolder, hashId),
	            #    which_models = c("bin_consensus", "raw_mean_cut"),
                   which_models = modelsArray[[1]],
	               consensus = F,
	               consensus_level = as.numeric(threshold_bin),
	               write_png = T)

	cat ('acabou pacote modler \n\n\n\n\n')
    #Ajuste título da imagem pasta ENSEMBLE
    for (model in modelsArray[[1]]) {
        ensemble_files <-  list.files(paste0(resultFolder, hashId,"/",especie, "/present/ensemble"),
                                recursive = T,
                                pattern = paste0(model,".+tif$"),
                                full.names = T)

        ensemble_files <- mixedsort(ensemble_files)
        titles <- c(paste0(model,"\nmean"), paste0(model,"\nmedian"), paste0(model,"\nrange"), paste0(model,"\nsd"))
        filenames <- c(paste0("_",model,"_mean"), paste0("_",model,"_median"), paste0("_",model,"_range"), paste0("_",model,"_sd"))

        if(length(ensemble_files)){
            for (val in c(1,2,3,4)) {
                png(filename = paste0(resultFolder, hashId,"/",especie, "/present/ensemble/",especie, filenames[val],".png"))
                r <- raster(ensemble_files[val])
                plot(r, main = titles[val])
                # coord <- coordenadas[, c(lon, lat)]
                maps::map("world", , add = T, col = "grey")
                # points(coord, pch = 19, cex = 0.3,
                #         col = scales::alpha("cyan", 0.6))
                dev.off()
            }
        }
    }

    #Ajuste título da imagem pasta FINAL MODELS
    for (model in modelsArray[[1]]) {
        ensemble_files <-  list.files(paste0(resultFolder, hashId,"/",especie, "/present/final_models"),
                                recursive = T,
                                pattern = paste0(model,".+tif$"),
                                full.names = T)

        if(length(ensemble_files)){
            for (file in ensemble_files) {
                for(algo in algorithsNames){
                    if(grepl(algo, file, fixed=TRUE)){
                        png(filename = paste0(resultFolder, hashId,"/",especie, "/present/final_models/",especie,"_",algo,"_",model,".png"))
                        r <- raster(file)
                        plot(r, main = paste0(algo,"\n",model))
                        # coord <- coordenadas[, c(lon, lat)]
                        maps::map("world", , add = T, col = "grey")
                        # points(coord, pch = 19, cex = 0.3,
                        #         col = scales::alpha("cyan", 0.6))
                        dev.off()
                    }
                }
            }
        }
    }



	#Criando a tabela com os valores de desempenho do modelo.

	lista <- list.files(paste0(resultFolder, hashId,'/',especie, '/present/partitions'), pattern = ".txt", full.names = T)
	aval <- c()
	for (i in 1:(length(lista) - 1)) {
	    a <- read.table(lista[i])
	    aval <- rbind(aval,a)
	    row.names(aval) <- NULL
	    print(head(aval,10))
	    write.table(aval,
	                paste0(resultFolder, hashId, '/', especie, ".csv"),
	                row.names = F, sep = ";")
	}
}